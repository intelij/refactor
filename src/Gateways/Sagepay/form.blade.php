{{--do not use Form::open because we don't want the hidden token field --}}
<form id="pa-form" method="post" action={{ $resp->acsUrl }}>
    {{ Form::hidden('PaReq', $resp->PaReq)}}
    {{ Form::hidden('TermUrl', $resp->TermUrl) }}
    {{ Form::hidden('MD', $resp->MD) }}
    {{ Form::hidden('transactionId', $resp->TermUrl) }}}}
</form>
<script>document.addEventListener("DOMContentLoaded",function(){var b=document.getElementById("pa-form");b&&b.submit()})</script>