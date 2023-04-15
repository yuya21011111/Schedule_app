@auth 
<x-event-detail-auth
:event='$event'
:reservedPeople='$reservedPeople'
:isReserved="$isReserved" 
/>
@endauth

@guest 
<x-event-detail-guest
:event='$event'
:reservedPeople='$reservedPeople'
:isReserved="$isReserved" 
/>
@endguest