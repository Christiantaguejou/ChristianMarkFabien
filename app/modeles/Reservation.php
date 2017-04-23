<?php

namespace App\modeles;

use DateInterval;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Model;
use DB;

class Reservation extends Model
{
    /**
     * Ajouter une reservation d'oeuvre
     * @param int $id_oeuvre
     * @param int $id_adherent
     * @param DateTime $date_reservation
     * @param String $statut
     * @throws \App\modeles\Exception
     */
    public function addReservation($id_oeuvre, $id_adherent, $date_reservation, $statut){
        date_default_timezone_set("Europe/Paris");
        $time = date("h:i:sa");
        $date = new DateTime($date_reservation. $time);
        try{
            DB::table('reservation')->insert(
                ['id_oeuvre'=> $id_oeuvre,
                'id_adherent' => $id_adherent,
                'date_reservation' => $date,
                'statut' => $statut]
            );
        } catch (Exception $ex){
            throw $ex;
        }
    }

    public function getReservations(){
        $reservations = DB::table('reservation')
            ->Select('reservation.id_oeuvre','date_reservation','adherent.nom_adherent','adherent.prenom_adherent', 'statut','titre')
            ->join('adherent', 'adherent.id_adherent', '=','reservation.id_adherent')
            ->join('oeuvre','oeuvre.id_oeuvre','=','reservation.id_oeuvre')
            ->get();

        //date_format('date_reservation', "d-m-Y H:i:s")
        return $reservations;
    }
    public function confirmerReservation($idOeuvre, $date){
        try{

            $tmp=DB::table('reservation')
                ->Select('statut')
                ->where([
                    ['id_oeuvre','=',$idOeuvre],
                    ['date_reservation','=', $date]
                ])
                ->get();
            if( $tmp != "Confirmée")
             {
                $statut = "Confirmée";
                DB::table('reservation')
                    ->where([
                        ['id_oeuvre', '=', $idOeuvre],
                        ['date_reservation', '=', $date]
                    ])
                    //->delete();
                    ->update(['statut' => $statut])
                    ;

            }
        }catch (Exception $ex){
            throw $ex;
        }
    }

    /**
     * @param $idOeuvre
     * @param $date
     * @return Reservation à supprimer
     */
    public function getReservation($idOeuvre, $date){
        $reservation = DB::table('reservation')
            ->where([
                ['id_oeuvre','=', $idOeuvre],
                ['date_reservation','=', $date]
            ])
            ->get();
        return $reservation;
    }

    /**
     * @param $date Date date de reservation
     * @param $idOeuvre int id de l oeuvre
     * @param $idAdherent int id adherent
     * @throws \Exception
     */
    public function deleteReservation($idOeuvre,$date){
        try{
            DB::table('reservation')
                ->where([
                    ['id_oeuvre','=',$idOeuvre],
                    ['date_reservation','=', $date]
                    ])
                ->delete();
        }catch (Exception $ex){
            throw $ex;
        }
    }


}
