<?php

namespace Zoop\Payment\Paypal\Common;

use PayPal\PayPalAPI\TransactionSearchReq;
use PayPal\PayPalAPI\TransactionSearchRequestType;
use PayPal\PayPalAPI\TransactionSearchResponseType;
use PayPal\EBLBaseComponents\PaymentTransactionSearchResultType;
use \DateTime;

class TransactionSearch extends AbstractMerchant
{
    const MAX_RESULTS = 100;

    public function search(DateTime $dateFrom, DateTime $dateTo, $transactionId = null)
    {
        $transactionSearchRequest = new TransactionSearchRequestType();
        $transactionSearchRequest->StartDate = $dateFrom->format('Y-m-d\TH:i:sO');
        $transactionSearchRequest->EndDate = $dateTo->format('Y-m-d\TH:i:sO');
        if (!empty($transactionId)) {
            $transactionSearchRequest->TransactionID = $transactionId;
        }

        $tranSearchReq = new TransactionSearchReq();
        $tranSearchReq->TransactionSearchRequest = $transactionSearchRequest;

        /* @var $transactionResults TransactionSearchResponseType */
        $transactionResults = $this->getMerchantService()->TransactionSearch($tranSearchReq);
        if (!empty($transactionResults->Errors) && count($transactionResults->PaymentTransactions) == self::MAX_RESULTS) {
            //need to reduce the date range and search again
            /* @var $lastTransaction PaymentTransactionSearchResultType */
            $lastTransaction = $transactionResults->PaymentTransactions[self::MAX_RESULTS - 1];

            $newDateTo = new DateTime();
            $newDateTo->setTimestamp(strtotime($lastTransaction->Timestamp));

            $newTransactionResults = $this->search($dateFrom, $newDateTo, $transactionId);

            $transactionResults->PaymentTransactions = $this->mergeTransactions($transactionResults->PaymentTransactions, $newTransactionResults->PaymentTransactions);

            //remove errors
            $transactionResults->Errors = [];
        }

        //sort
        $this->orderByDate($transactionResults->PaymentTransactions);

        return $transactionResults;
    }

    private function mergeTransactions($originalTransactions, $newTransactions)
    {
        /* @var $transaction PaymentTransactionSearchResultType */
        foreach ($newTransactions as $transaction) {
            if ($this->inTransactionArray($transaction, $originalTransactions) === false) {
                $originalTransactions[] = $transaction;
            }
        }
        return $originalTransactions;
    }

    private function inTransactionArray(PaymentTransactionSearchResultType $needle, $haystack)
    {
        /* @var $item PaymentTransactionSearchResultType */
        foreach ($haystack as $item) {
            if ($needle->TransactionID == $item->TransactionID) {
                return true;
            }
        }
        return false;
    }

    private function orderByDate(&$transactions)
    {
        if (!empty($transactions)) {
            $dates = [];
            /* @var $transaction PaymentTransactionSearchResultType */
            foreach ($transactions as $transaction) {
                $dates[] = $transaction->Timestamp;
            }

            array_multisort($dates, SORT_ASC, $transactions);
        }
    }
}