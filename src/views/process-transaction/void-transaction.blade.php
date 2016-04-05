<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pv="https://ssl.selectpayment.com/PV">
	<soapenv:Header/>
	<soapenv:Body>
		<pv:VoidTransaction>
			<pv:storeId>{{ config('profit-stars.store-id', env('PROFIT_STARS_STORE_ID')) }}</pv:storeId>
			<pv:storeKey>{{ config('profit-stars.store-key', env('PROFIT_STARS_STORE_KEY')) }}</pv:storeKey>
			<pv:EntityId>{{ config('profit-stars.entity-id', env('PROFIT_STARS_ENTITY_ID')) }}</pv:EntityId>
			<pv:LocationId>{{ config('profit-stars.location-id', env('PROFIT_STARS_LOCATION_ID')) }}</pv:LocationId>
			<pv:originalReferenceNumber>{{ $originalReferenceNumber }}</pv:originalReferenceNumber>
		</pv:VoidTransaction>
	</soapenv:Body>
</soapenv:Envelope>