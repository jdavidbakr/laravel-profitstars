<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pv="https://ssl.selectpayment.com/PV">
	<soapenv:Header/>
	<soapenv:Body>
		<pv:AuthorizeTransaction>
			<pv:storeId>{{ config('profit-stars.store-id', env('PROFIT_STARS_STORE_ID')) }}</pv:storeId>
			<pv:storeKey>{{ config('profit-stars.store-key', env('PROFIT_STARS_STORE_KEY')) }}</pv:storeKey>
			<pv:transaction>
				<pv:EntityId>{{ config('profit-stars.entity-id', env('PROFIT_STARS_ENTITY_ID')) }}</pv:EntityId>
				<pv:LocationId>{{ config('profit-stars.location-id', env('PROFIT_STARS_LOCATION_ID')) }}</pv:LocationId>
				<pv:PaymentOrigin>{{ $trans->PaymentOrigin }}</pv:PaymentOrigin>
				<pv:AccountType>{{ $trans->AccountType }}</pv:AccountType>
				<pv:OperationType>Auth</pv:OperationType>
				<pv:SettlementType>{{ $trans->SettlementType }}</pv:SettlementType>
				<pv:EffectiveDate>{{ $trans->EffectiveDate }}</pv:EffectiveDate>
				<pv:Description>{{ $trans->Description }}</pv:Description>
				<pv:TotalAmount>{{ $trans->TotalAmount }}</pv:TotalAmount>
				<pv:Sale></pv:Sale>
				<pv:ConvenienceFeeAmount></pv:ConvenienceFeeAmount>
				<pv:TerminalNumber>{{ $trans->TerminalNumber }}</pv:TerminalNumber>
				<pv:TransactionNumber>{{ $trans->TransactionNumber }}</pv:TransactionNumber>
				<pv:Field1></pv:Field1>
				<pv:Field2></pv:Field2>
				<pv:Field3></pv:Field3>
				<pv:CheckMICRLine></pv:CheckMICRLine>
				<pv:CheckMICRSymbolSet></pv:CheckMICRSymbolSet>
				<pv:RoutingNumber>{{ $trans->RoutingNumber }}</pv:RoutingNumber>
				<pv:AccountNumber>{{ $trans->AccountNumber }}</pv:AccountNumber>
				<pv:CheckNumber></pv:CheckNumber>
				<pv:SwipeTrack1></pv:SwipeTrack1>
				<pv:SwipeTrack2></pv:SwipeTrack2>
				<pv:SwipeTrack3></pv:SwipeTrack3>
				<pv:IsBusinessPayment>0</pv:IsBusinessPayment>
				<pv:NameOnAccount>{{ $trans->NameOnAccount }}</pv:NameOnAccount>
				<pv:BillingAddress1>{{ $trans->BillingAddress1 }}</pv:BillingAddress1>
				<pv:BillingAddress2>{{ $trans->BillingAddress2 }}</pv:BillingAddress2>
				<pv:BillingCity>{{ $trans->BillingCity }}</pv:BillingCity>
				<pv:BillingStateRegion>{{ $trans->BillingStateRegion }}</pv:BillingStateRegion>
				<pv:BillingPostalCode>{{ $trans->BillingPostalCode }}</pv:BillingPostalCode>
				<pv:BillingCountry>{{ $trans->BillingCountry }}</pv:BillingCountry>
				<pv:BillingPhone>{{ $trans->BillingPhone }}</pv:BillingPhone>
				<pv:IpAddressOfOriginator>{{ $trans->IpAddressOfOriginator }}</pv:IpAddressOfOriginator>
				<pv:EmailAddress>{{ $trans->EmailAddress }}</pv:EmailAddress>
				<pv:SSN></pv:SSN>
				<pv:DLState></pv:DLState>
				<pv:DLNumber></pv:DLNumber>
				<pv:CheckFrontImageBytes_TiffG4></pv:CheckFrontImageBytes_TiffG4>
				<pv:CheckRearImageBytes_TiffG4></pv:CheckRearImageBytes_TiffG4>
				<pv:OptionalThirdImageBytes_TiffG4></pv:OptionalThirdImageBytes_TiffG4>
				<pv:OptionalThirdImageDescription></pv:OptionalThirdImageDescription>
			</pv:transaction>
		</pv:AuthorizeTransaction>
	</soapenv:Body>
</soapenv:Envelope>
