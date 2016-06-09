<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	<soap:Body>
		<RegisterCustomer xmlns="https://ssl.selectpayment.com/PV">
			<storeId>{{ config('profit-stars.store-id', env('PROFIT_STARS_STORE_ID')) }}</storeId>
			<storeKey>{{ config('profit-stars.store-key', env('PROFIT_STARS_STORE_KEY')) }}</storeKey>
			<entityId>{{ config('profit-stars.entity-id', env('PROFIT_STARS_ENTITY_ID')) }}</entityId>
			<customer>
				<EntityId>{{ config('profit-stars.entity-id', env('PROFIT_STARS_ENTITY_ID')) }}</EntityId>
				<IsCompany>{{ $customer->IsCompany?'1':'0' }}</IsCompany>
				<CustomerNumber>{{ $customer->CustomerNumber }}</CustomerNumber>
				<Field1></Field1>
				<Field2></Field2>
				<Field3></Field3>
				<FirstName>{{ $customer->FirstName }}</FirstName>
				<LastName>{{ $customer->LastName }}</LastName>
				<Email>{{ $customer->Email }}</Email>
				<OtherEmail></OtherEmail>
				<Address1>{{ $customer->Address1 }}</Address1>
				<Address2>{{ $customer->Address2 }}</Address2>
				<City>{{ $customer->City }}</City>
				<StateRegion>{{ $customer->StateRegion }}</StateRegion>
				<PostalCode>{{ $customer->PostalCode }}</PostalCode>
				<Country>{{ $customer->Country }}</Country>
				<EveningPhone>{{ $customer->EveningPhone }}</EveningPhone>
				<EveningExt>{{ $customer->EveningExt }}</EveningExt>
				<DaytimePhone>{{ $customer->DaytimePhone }}</DaytimePhone>
				<DaytimeExt></DaytimeExt>
				<Fax></Fax>
				<SSN>{{ $customer->SSN }}</SSN>
				<DLState>{{ $customer->DLState }}</DLState>
				<DLNumber>{{ $customer->DLNumber }}</DLNumber>
			</customer>
		</RegisterCustomer>
	</soap:Body>
</soap:Envelope>
