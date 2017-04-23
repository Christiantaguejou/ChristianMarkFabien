        @if($erreur != "")
        <p>
            <div class="alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Il y a eu une erreur MySQL dont le code est : {{$erreur or '' }} .
            </div>
        </p>
        @endif