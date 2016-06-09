<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	<soap:Body>
		<SetupRecurringPayment xmlns="https://ssl.selectpayment.com/PV">
			<storeId>{{ config('profit-stars.store-id', env('PROFIT_STARS_STORE_ID')) }}</storeId>
			<storeKey>{{ config('profit-stars.store-key', env('PROFIT_STARS_STORE_KEY')) }}</storeKey>
			<entityId>{{ config('profit-stars.entity-id', env('PROFIT_STARS_ENTITY_ID')) }}</entityId>
			<recurr>
				<EntityId>{{ config('profit-stars.entity-id', env('PROFIT_STARS_ENTITY_ID')) }}</EntityId>
				<CustomerNumber>{{ $recur->CustomerNumber }}</CustomerNumber>
				<AccountReferenceID>{{ $recur->AccountReferenceID }}</AccountReferenceID>
				<LocationId>{{ config('profit-stars.location-id', env('PROFIT_STARS_LOCATION_ID')) }}</LocationId>
				<Description>{{ $recur->Description }}</Description>
				<Amount>{{ $recur->Amount }}</Amount>
				@if(!empty($recur->InvoiceNumber))
				<InvoiceNumber>{{ $recur->InvoiceNumber }}</InvoiceNumber>
				@endif
				<Frequency>{{ $recur->Frequency }}</Frequency>
				<PaymentDay>{{ $recur->PaymentDay }}</PaymentDay>
				<StartDate>{{ $recur->StartDate }}</StartDate>
				<NumPayments>{{ $recur->NumPayments }}</NumPayments>
				<PaymentsToDate>{{ $recur->PaymentsToDate }}</PaymentsToDate>
				<NotificationMethod>{{ $recur->NotificationMethod }}</NotificationMethod>
				<NextPaymentDate>{{ $recur->NextPaymentDate }}</NextPaymentDate>
				<Enabled>{{ $recur->Enabled }}</Enabled>
				<RecurringReferenceID>{{ $recur->RecurringReferenceID }}</RecurringReferenceID>
			</recurr>
		</SetupRecurringPayment>
	</soap:Body>
</soap:Envelope>
