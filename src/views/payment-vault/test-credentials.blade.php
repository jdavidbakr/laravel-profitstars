<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pv="https://ssl.selectpayment.com/PV">
	<soapenv:Header/>
	<soapenv:Body>
		<pv:TestCredentials>
			<pv:storeId>{{ config('profit-stars.store-id', env('PROFIT_STARS_STORE_ID')) }}</pv:storeId>
			<pv:storeKey>{{ config('profit-stars.store-key', env('PROFIT_STARS_STORE_KEY')) }}</pv:storeKey>
			<pv:entityId>{{ config('profit-stars.entity-id', env('PROFIT_STARS_ENTITY_ID')) }}</pv:entityId>
			<pv:locationId>{{ config('profit-stars.location-id', env('PROFIT_STARS_LOCATION_ID')) }}</pv:locationId>
			<pv:terminalNumber>__WebService</pv:terminalNumber>
		</pv:TestCredentials>
	</soapenv:Body>
</soapenv:Envelope>
