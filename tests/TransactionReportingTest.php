<?php

namespace jdavidbakr\ProfitStars\Test;

use Carbon\Carbon;
use jdavidbakr\ProfitStars\CreditAndDebitReportsResponse;
use jdavidbakr\ProfitStars\TransactionReporting;
use Mockery;
use Psr\Http\Message\ResponseInterface;

class TransactionReportingTest extends BaseTestCase
{
    protected $object;

    public function setUp(): void
    {
        parent::setUp();
        $this->object = new TransactionReporting;
    }

    public function testCreditAndDebitReports()
    {
        $this->guzzle->shouldReceive('post')
            ->once()
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <soap:Body>
                        <CreditandDebitReportsResponse xmlns="https://ssl.selectpayment.com/PV">
                            <CreditandDebitReportsResult>
                                <diffgr:diffgram xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1">
                                    <NewDataSet xmlns="">
                                        <Table diffgr:id="Table1" msdata:rowOrder="0">
                                            <BatchStatus>Processed</BatchStatus>
                                            <EffectiveDate>2021-01-11T00:00:00-06:00</EffectiveDate>
                                            <BatchID>1234567</BatchID>
                                            <Description>Settlement</Description>
                                            <Amount>-100.0000</Amount>
                                        </Table>
                                        <Table diffgr:id="Table2" msdata:rowOrder="1">
                                            <BatchStatus>Processed</BatchStatus>
                                            <EffectiveDate>2021-01-12T00:00:00-06:00</EffectiveDate>
                                            <BatchID>1234568</BatchID>
                                            <Description>Settlement</Description>
                                            <Amount>100.0000</Amount>
                                        </Table>
                                    </NewDataSet>
                                </diffgr:diffgram>
                            </CreditandDebitReportsResult>
                        </CreditandDebitReportsResponse>
                    </soap:Body>
                </soap:Envelope>'
            ]));
        $start_date = Carbon::now()->subDays(90);
        $end_date = Carbon::now();

        $response = $this->object->CreditAndDebitReports($start_date, $end_date);
        $this->assertNotNull($response);

        if (!$response->count()) {
            // We can't preload the data, so just mark the test incomplete if we have nothing
            $this->markTestIncomplete();
            return;
        }

        $response->each(function ($item) {
            $this->assertEquals(CreditAndDebitReportsResponse::class, get_class($item));
        });
    }

    public function testCreditsAndDebitsTransactionDetailReport()
    {
        $this->guzzle->shouldReceive('post')
            ->once()
            ->andReturn(Mockery::mock(ResponseInterface::class, [
                'getBody'=>'<?xml version="1.0" encoding="utf-8"?>
                    <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                        <soap:Body>
                            <CreditsandDebitsTransactionDetailReportResponse xmlns="https://ssl.selectpayment.com/PV">
                                <CreditsandDebitsTransactionDetailReportResult>
                                    <WSSettlementBatch>
                                    </WSSettlementBatch>
                                </CreditsandDebitsTransactionDetailReportResult>
                            </CreditsandDebitsTransactionDetailReportResponse>
                        </soap:Body>
                    </soap:Envelope>'
            ]));
        $start_date = Carbon::now()->subDays(90);
        $end_date = Carbon::now();

        $transactions = $this->object->CreditsAndDebitsTransactionDetailReport('batch-id');
        $this->assertGreaterThan(0, $transactions->count());
    }
}
