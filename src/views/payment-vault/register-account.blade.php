<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	<soap:Body>
		<RegisterAccount xmlns="https://ssl.selectpayment.com/PV">
			<storeId>{{ config('profit-stars.store-id', env('PROFIT_STARS_STORE_ID')) }}</storeId>
			<storeKey>{{ config('profit-stars.store-key', env('PROFIT_STARS_STORE_KEY')) }}</storeKey>
			<entityId>{{ config('profit-stars.entity-id', env('PROFIT_STARS_ENTITY_ID')) }}</entityId>
			<account>
				<CustomerNumber>{{ $account->CustomerNumber }}</CustomerNumber>
				<AccountType>{{ $account->AccountType }}</AccountType>
				<NameOnAccount>{{ $account->NameOnAccount }}</NameOnAccount>
				<AccountName>{{ $account->AccountName }}</AccountName>
				<AccountNumber>{{ $account->AccountNumber }}</AccountNumber>
				<RoutingNumber>{{ $account->RoutingNumber }}</RoutingNumber>
				<BillAddress1>{{ $account->BillAddress1 }}</BillAddress1>
				<BillAddress2>{{ $account->BillAddress2 }}</BillAddress2>
				<BillCity>{{ $account->BillCity }}</BillCity>
				<BillStateRegion>{{ $account->BillStateRegion }}</BillStateRegion>
				<BillPostalCode>{{ $account->BillPostalCode }}</BillPostalCode>
				<BillCountry>{{ $account->BillCountry }}</BillCountry>
				<AccountReferenceID>{{ $account->AccountReferenceID }}</AccountReferenceID>
			</account>
		</RegisterAccount>
	</soap:Body>
</soap:Envelope>