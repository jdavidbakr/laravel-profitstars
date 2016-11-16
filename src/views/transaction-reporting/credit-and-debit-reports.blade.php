<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pv="https://ssl.selectpayment.com/PV">
	<soapenv:Header/>
	<soapenv:Body>
		<pv:CreditandDebitReports>
			<pv:storeId>{{ config('profit-stars.store-id', env('PROFIT_STARS_STORE_ID')) }}</pv:storeId>
			<pv:storeKey>{{ config('profit-stars.store-key', env('PROFIT_STARS_STORE_KEY')) }}</pv:storeKey>
			<pv:entityId>{{ config('profit-stars.entity-id', env('PROFIT_STARS_ENTITY_ID')) }}</pv:entityId>
			<pv:locationIds>
				<pv:int>{{ config('profit-stars.location-id', env('PROFIT_STARS_LOCATION_ID')) }}</pv:int>
			</pv:locationIds>
			<pv:beginDate>
				{{ $beginDate->format("Y-m-d") }}
			</pv:beginDate>
			<pv:endDate>
				{{ $endDate->format("Y-m-d") }}
			</pv:endDate>
		</pv:CreditandDebitReports>
	</soapenv:Body>
</soapenv:Envelope>
