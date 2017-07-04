<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 30/06/2017
 * Time: 11:42
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Mobility;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMobilityData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $regions = array(
            'Auvergne-Rhône-Alpes',
            'Bourgogne-Franche-Comté',
            'Bretagne',
            'Centre-Val de Loire',
            'Corse',
            'Grand Est',
            'Hauts-de-France',
            'Île-de-France',
            'Normandie',
            'Nouvelle-Aquitaine',
            'Occitanie',
            'Pays de la Loire',
            'Provence-Alpes-Côte d\'Azur',
            'Guadeloupe',
            'Guyane',
            'Martinique',
            'Réunion',
            'Mayotte',
            'Etranger - Union Européenne',
            'Etranger - Hors Union Européenne',
        );
        foreach($regions as $region){
            $mobility = new Mobility();
            $mobility->setName($region);
            $manager->persist($mobility);
        }
        $manager->flush();
    }
}