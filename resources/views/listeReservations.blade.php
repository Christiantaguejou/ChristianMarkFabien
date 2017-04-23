@extends('layouts.master')
@section('content')
    <script type="text/javascript" >
        function myFunction(date) {
            var d= new Date(date);
            document.getElementById("date_reservation").innerHTML = d;
        }
    </script>
    <div class="container">
        <div class="blanc">
            <h1>Liste des réservations</h1>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Titre</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Prénom adhérent</th>
                <th>Nom adhérent</th>
                <th>Confirmer</th>
                <th>Supprimer</th>
            </tr>
            </thead>
            @foreach($reservations as $reservation)
                <tr>

                    <td> {{$reservation->titre or ''}}</td>
                    <td id="date_reservation" onbeforeprint="javascript:myFunction({{$reservation->date_reservation or ''}});"> </td>
                        <!--{{$reservation->date_reservation or ''}}  -->
                    <td>  {{$reservation->statut or ''}}</td>
                    <td>  {{$reservation->nom_adherent or ''}} </td>
                    <td>  {{$reservation->prenom_adherent or ''}} </td>

                    <td style="text-align:center;"><a href="#" onclick="javascript:if (confirm('Confirmer la réservation ?'))
                                { window.location='{{ url('/confirmerReservation') }}/{{ $reservation -> id_oeuvre }}/{{$reservation->date_reservation}}';}">
                            <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="Confirmer">

                            </span></a>
                    </td>
                    <td style="text-align:center;">
                        <a class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="top" title="Supprimer" href="#"
                           onclick="javascript:if (confirm('Suppression confirmée ?'))
                        { window.location='{{ url('/supprimerReservation') }}/{{ $reservation -> id_oeuvre }}/{{$reservation->date_reservation}}';}">
                        </a>
                    </td>
                </tr>
            @endforeach
            <BR> <BR>
        </table>
        <div class="col-md-6 col-md-offset-3">
            @include('error')
        </div>
    </div>
@stop