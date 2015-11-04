<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pv="https://ssl.selectpayment.com/PV">
	<soapenv:Header/>
	<soapenv:Body>
		<pv:VoidTransaction>
			<pv:storeId>{{ config('profit-stars.store-id') }}</pv:storeId>
			<pv:storeKey>{{ config('profit-stars.store-key') }}</pv:storeKey>
			<pv:entityId>{{ config('profit-stars.entity-id') }}</pv:entityId>
			<pv:locationId>{{ config('profit-stars.location-id') }}</pv:locationId>
			<pv:originalReferenceNumber>{{ $originalReferenceNumber }}</pv:originalReferenceNumber>
		</pv:VoidTransaction>
	</soapenv:Body>
</soapenv:Envelope>