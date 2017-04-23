<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

use App\Http\Requests;
use App\modeles\Proprietaire;
use Request;
use App\modeles\Oeuvre;
use App\Exceptions;


class OeuvreController extends Controller
{
    public function getOeuvres(){
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $oeuvre = new Oeuvre();
        
        $oeuvres = $oeuvre -> getOeuvres();
        return view('listeOeuvres', compact('oeuvres', 'erreur'));
    }

    /**
     * Initialise toutes les listes déroulantes
     * Lit l'oeuvre à modifier
     * Initialise le formulaire en mode Modification
     * @param $id
     * @param string $erreur
     * @return Vue modifierOeuvre
     */

    public function updateOeuvre($id, $erreur){
        $laOeuvre = new Oeuvre();
        $oeuvre = $laOeuvre->getOeuvre($id);
        $proprietaire = new Proprietaire();
        $proprietaires = $proprietaire->getProprietaire();
        $titreVue = "Modification d'une Oeuvre";
        //Affiche le formulaire en lui fournissant les données à afficher
        return view('formOeuvre', compact('oeuvre','proprietaires','titreVue','erreur'));
    }

    /**
     * Initialise toutes les listes déroulantes
     * Place le formulaire formOeuvre en mode ajout
     * @param string $erreur
     * @return Vue Ajouter une Oeuvre
     */
    public function addOeuvre($erreur=""){
        $oeuvre = new Oeuvre();
        $proprietaire = new Proprietaire();
        $proprietaires = $proprietaire->getProprietaire();
        $titreVue = "Ajouter une Oeuvre";
        //Affiche le formulaire en lui fournissant les données à afficher
        return view('formOeuvre', compact('oeuvre', 'proprietaires', 'titreVue', 'erreur'));
    }

    public function validateOeuvre(){
        //Récupération des valeurs saisies
        $id_oeuvre = Request::input('id_oeuvre');
        $titre_oeuvre = Request::input('titre');
        $proprietaire = Request::input('cbProprietaire');
        $prix = Request::input('prix');
        $oeuvre = new Oeuvre();
        try{
            if($id_oeuvre>0){
                $oeuvre->updateOeuvre($id_oeuvre,$titre_oeuvre,$prix,$proprietaire);
            }
            else{
                $oeuvre->addOeuvre($titre_oeuvre, $proprietaire, $prix);
            }
        }catch (\Exception $ex){
            $erreur = $ex->getCode();
            //Session::put('erreur',$erreur);
            if($id_oeuvre>0){
                return $this->updateOeuvre($id_oeuvre, $erreur);
                //$this->updateOeuvre($id_oeuvre, $erreur);
            }
            else{
               return $this->addOeuvre($erreur);
               // $this->addOeuvre($erreur);
            }
        }
        //On reaffiche la listes des oeuvres
        return redirect('/listerOeuvres');
    }

    public function deleteOeuvre($id, $erreur=""){
        $oeuvre = new Oeuvre();
        try{
            $oeuvre->deleteOeuvre($id);
        }catch (\Exception $ex){
            $erreur = $ex->getCode();
        }
        return redirect('/listerOeuvres');
    }
}
