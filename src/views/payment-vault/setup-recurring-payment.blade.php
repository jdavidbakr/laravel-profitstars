<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pv="https://ssl.selectpayment.com/PV">
   <soapenv:Header/>
   <soapenv:Body>
      <pv:SetupRecurringPayment>
         <pv:storeId>{{ config('profit-stars.store-id', env('PROFIT_STARS_STORE_ID')) }}</pv:storeId>
         <pv:storeKey>{{ config('profit-stars.store-key', env('PROFIT_STARS_STORE_KEY')) }}</pv:storeKey>
         <pv:entityId>{{ config('profit-stars.entity-id', env('PROFIT_STARS_ENTITY_ID')) }}</pv:entityId>
         <pv:wsRecurr>
            <pv:CustomerNumber>{{ $recur->CustomerNumber }}</pv:CustomerNumber>
            <pv:AccountReferenceID>{{ $recur->AccountReferenceID }}</pv:AccountReferenceID>
            <pv:LocationID>{{ config('profit-stars.location-id', env('PROFIT_STARS_LOCATION_ID')) }}</pv:LocationID>
            <pv:Amount>{{ $recur->Amount }}</pv:Amount>
            <pv:Description>{{ $recur->Description }}</pv:Description>
            <pv:InvoiceNumber>{{ $recur->InvoiceNumber }}</pv:InvoiceNumber>
            <pv:Frequency>{{ $recur->Frequency }}</pv:Frequency>
            <pv:PaymentDay>{{ $recur->PaymentDay }}</pv:PaymentDay>
            <pv:StartDate>{{ $recur->StartDate }}</pv:StartDate>
            <pv:NumPayments>{{ $recur->NumPayments }}</pv:NumPayments>
            <pv:PaymentsToDate>{{ $recur->PaymentsToDate }}</pv:PaymentsToDate>
            <pv:NotificationMethod>{{ $recur->NotificationMethod }}</pv:NotificationMethod>
            <pv:NextPaymentDate>{{ $recur->NextPaymentDate }}</pv:NextPaymentDate>
            <pv:Enabled>{{ $recur->Enabled }}</pv:Enabled>
            <pv:PaymentOrigin>Internet</pv:PaymentOrigin>
            <pv:RecurringReferenceID>{{ $recur->RecurringReferenceID }}</pv:RecurringReferenceID>
         </pv:wsRecurr>
      </pv:SetupRecurringPayment>
   </soapenv:Body>
</soapenv:Envelope>