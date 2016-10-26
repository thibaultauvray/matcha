<?php

class Model
{

    protected $app;
    public $name;

    public function __construct($app)
    {
        $this->app = $app;
        $this->name = strtolower(get_called_class());
    }

    public function fillDB()
    {
        $pdo = $this->app->db;
        $orientation = ['bisexuel', 'hetero', 'homosexuel'];
        $interest = ['running', 'voilier', 'catamaran', 'planche à voile', 'svelte', 'proust', 'almodovar', 'madmen', 'catamaran', 'blonde', 'brune', 'lelivresansnom', 'donniedarko' ,'theitcrowd', 'cancan', 'blonde', 'howtomakeitinamerica', 'paris15', 'yeuxbleus', 'piercing', 'cuisine', 'timbaland', 'prettylittleliars',
            'blonde', 'cuisine', 'bcbg' ,'sciences' ,'unettes', 'danse', 'lunettes', 'etudianteinfirmiere', 'concerts', 'harrypotter', 'drhouse', 'piercing', 'cuisine' ,'instabouffe', 'bierpong', 'chiens', 'chic',  'jazz' ,'heat' ,'prisonbreak' ,'zook', 'infirmiere' ,'hautbois' ,'batondepluie', 'flute', 'pandas',
            'lolita', 'tatouée', 'cheveuxcourts', 'juriste' ,'hippiechic', 'nicolasjaar', 'reservoirdog',  'zola' ,'gameofthrones', 'flute' ,'cheveuxlongs' ,'guitare', 'svelte', 'voyages' ,'yodelice' ,'ecumedesjours', 'lavieestbelle', 'chats', 'bonbon', 'tatouée', 'chats' ,'bonbon' ,'tatouée',
            'cuisine', 'nonfumeuse', 'menageastiquer', 'lunettes',  'cordeasauter', 'piercing',  'athletisme', 'yeuxbleus' ,'vtt', 'piscine' , 'globetrotter', 'orgueiletprejuges', 'ncis' , 'comiccon',  'arrow' ,'histoire', 'hipster',  'chopin',  'saw', 'blues', 'walkingdead', 'lecture', 'metal',
            'cheveuxcourts', 'bowling',  'hippiechic', 'dessin', 'rousse',  'badminton', 'martinscorsese', 'californication', 'paris18', 'karate', 'basket', 'judo', 'tennis', 'tennisdetable', 'furet', 'cheval', 'vegan', 'femen'

        ];
        $wikipediaURL = 'https://randomuser.me/api/?nat=fr&results=200';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $wikipediaURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $resultat = json_decode(curl_exec ($ch));
        curl_close($ch);
        foreach ($resultat->results as $key => $v)
        {
            if ($v->gender == "female")
                $gender = "f";
            else
                $gender = "m";
            $name = $v->name->first;
            $lastname = $v->name->last;
            $nickname = substr(ucfirst($v->login->username), 0, strlen($v->login->username) - 3);
            $mail = $v->email . uniqid();
            $password = hash('whirlpool', 'QwertY81');
            $orien = $orientation[mt_rand(0, 2)];
            $ch = curl_init();
            $city = $v->location->city;
            $Url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($v->location->city).'&sensor=false';
            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            $search_data = json_decode($output);
            $latitude = $search_data->results[0]->geometry->location->lat;
            $longitutude = $search_data->results[0]->geometry->location->lng;
            $path = 'img/img/' . uniqid() . ".jpg";
            $url = $v->picture->large;

            $fp = fopen($path, 'w');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            $data = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            $curl_error = curl_error($ch);
            curl_close($ch);
            fclose($fp);

            $nbInteret = mt_rand(1, 5);
            $int = array();
            for ($i = 0;$i <= $nbInteret; $i++)
            {
                $rand = mt_rand(0, 112);
                $int[] = $interest[$rand];
            }
            $age = mt_rand(18, 60);
            $path = substr($path, 4, strlen($path));
            $int = array_unique($int);
            $id = $this->insertFillDB('users', array("nickname"     => $nickname,
                                                     "name"        => $name,
                                                     "lastname"    => $lastname,
                                                     "mail"        => $mail,
                                                     "passwd"      => $password,
                                                     "gender"      => $gender,
                                                     "orientation" => $orien,
                                                     "age"         => $age));
            $this->insertFillDB('usersImage', array("url"      => $path,
                                                    "isprofil" => 1,
                                                    "id_users" => $id));
            $this->insertFillDB('usersLocation', array('longitude' => $longitutude,
                                                       'latitude'  => $latitude,
                                                       'city'      => $city,
                                                       'id_users'  => $id));

            foreach ($int as $int)
            {
                $int = trim($int);
                $id_interest = $pdo->prepare("SELECT id FROM usersInterest WHERE interest = '$int'");
                $id_interest->execute();
                $idInt = $id_interest->fetch()['id'];
                if($idInt)
                {
                    $this->insertFillDB('users_usersInterest', array('id_users' => $id,
                                                    'id_interest' => $idInt));
                }
                else
                {
                    $idInt = $this->insertFillDB('usersInterest', array('interest' => $int));
                    $this->insertFillDB('users_usersInterest', array('id_users' => $id,
                                                                     'id_interest' => $idInt));

                }
            }
        }
        $this->fillDB2();
        return true;
    }

    public function fillDB2()
    {
        $array =
            [
                'nickname'    => ['Perceval', 'Arthur', 'Dame du lac', 'Karadoc', 'Guenievre', 'Lancelot', 'Merlin', 'Leodagan', 'Bohort', 'Angharad', 'Aelis', 'Blaise', 'Le roi burgonde', 'Cesar', 'Caius', 'Demetra', 'Ellias', 'Gauvain', 'Kadoc', 'Yvain', 'Hubert Bonisseur de La Bath'],
                'firstname'   => ['Perceval', 'Arthur', 'Dame du lac', 'Karadoc', 'Guenievre', 'Lancelot', 'Merlin', 'Leodagan', 'Bohort', 'Angharad', 'Aelis', 'Blaise', 'Le roi burgonde', 'Cesar', 'Caius', 'Demetra', 'Ellias', 'Gauvain', 'Kadoc', 'Yvain', 'Hubert Bonisseur de La Bath'],
                'lastname'    => ['Perceval', 'Arthur', 'Dame du lac', 'Karadoc', 'Guenievre', 'Lancelot', 'Merlin', 'Leodagan', 'Bohort', 'Angharad', 'Aelis', 'Blaise', 'Le roi burgonde', 'Cesar', 'Caius', 'Demetra', 'Ellias', 'Gauvain', 'Kadoc', 'Yvain', 'Hubert Bonisseur de La Bath'],
                'mail'        => ['Perceval@gmail.fr', 'Arthur@gmail.fr', 'Damedulac@gmail.fr', 'Karadoc@gmail.fr', 'Guenievre@gmail.fr', 'Lancelot@gmail.fr', 'Merlin@gmail.fr', 'Leodagan@gmail.fr', 'Bohort@gmail.fr', 'Angharad@gmail.fr', 'Aelis@gmail.fr', 'Blaise@gmail.fr', 'Leroiburgonde@gmail.fr', 'Cesar@gmail', 'Caius@gmail', 'Demetra@gmail', 'Ellias@gmail', 'Gauvain@gmail', 'Kadoc@gmail', 'Yvain@gmail', 'HubertBonisseurdeLaBath@gmail'],
                'passwd'      => ['4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022'],
                'gender'      => ['m', 'm', 'f', 'm', 'f', 'f', 'm', 'm', 'f', 'f', 'f', 'm', 'm', 'f', 'f', 'f', 'm', 'm', 'm', 'f', 'f'],
                'orientation' => ['hetero', 'hetero', 'hetero', 'hetero', 'hetero', 'bisexuel', 'bisexuel', 'bisexuel', 'bisexuel', 'homosexuel', 'homosexuel', 'homosexuel', 'homosexuel', 'homosexuel', 'hetero', 'hetero', 'hetero', 'hetero', 'hetero', 'hetero', 'homosexuel'],
                'age'         => ['18', '19', '28', '35', '25', '40', '50', '19', '23', '30', '25', '35', '41', '18', '19', '24', '29', '36', '57', '19', '20'],
                'img'         => ['perceval.jpg', 'arthur.jpg', 'damedulac.jpg', 'karadoc.jpg', 'guenievre.jpg', 'lancelot.jpg', 'merlin.jpg', 'leodagan.jpg', 'bohort.jpg', 'angharad.jpg', 'aelis.jpg', 'blaise.jpg', 'burgonde.jpg', 'cesar.jpg', 'caius.jpg', 'demetra.jpg', 'ellias.jpg', 'gauvain.jpg', 'kadoc.jpg', 'yvain.jpg', 'bath.jpg'],
                'interest'    => ['tuning, beauf', 'tuning, cuisine', 'chanter, sono, LoL', 'tuning, sono, LoL', 'dance, nunchaku, baston, bar', '', 'tuning, casserolle, bagarre, wu tang', 'musique, tanuki, dance, bar', 'dance, bar', 'jardinage, luciole', 'serie, film', 'film, beauf', 'chanter, yelle', 'willy denzey, chanter', 'LoL, baston', 'glace, manger, jardinage, go', 'tarot, belotte, cuisine', 'boxe, bagarre', 'serie, tuning, beauf, chanter, sono, LoL, bar', 'yelle, bagarre, glace', 'danser'],
                'loca'        => ['48.888198,2.25769,Neuilly-sur-Seine', '48.879167,2.334595, Paris 09', '48.864715, 2.307129, Paris 08
', '48.845288, 2.387466, Paris 12', '48.836249, 2.311935, Paris 15', '48.83173, 2.344208, Paris 13', '48.811725,  2.347813, Gentilly', '48.832069, 2.404461, Paris 12', '48.523881,  2.092896, Sermaise', ' 47.890564, 1.895142, Orleans', '47.383474, 0.714111, Saint-Pierre-des-Corps', '47.344406, 1.164551, Chissay-en-Touraine', '43.612217, 1.40625, Toulouse', '43.592328, 2.252197, Castres', '43.616194, 3.878174, Montpellier', '43.612217, 4.880676, Saint-Martin-de-Crau', '47.23449, -1.582031, Nantes', '48.42191, -4.526367, Bohars', '49.15297, -0.373535, Fleury-sur-Orne', '49.887557, 2.318115, Amiens', '48.886392, 2.329102, Paris 18']
            ];
        $i = 0;
        $pdo = $this->app->db;
        while ($i < 21)
        {
            foreach ($array as $user => $value)
            {
                switch ($user)
                {
                    case "nickname" :
                        $nick = $value[$i];
                        break;
                    case "firstname" :
                        $first = $value[$i];
                        break;
                    case "lastname" :
                        $last = $value[$i];
                        break;
                    case "mail" :
                        $mail = $value[$i];
                        break;
                    case "passwd" :
                        $passwd = $value[$i];
                        break;
                    case "gender" :
                        $gender = $value[$i];
                        break;
                    case "orientation" :
                        $orientation = $value[$i];
                        break;
                    case "age" :
                        $age = $value[$i];
                        break;
                    case "img" :
                        $img = $value[$i];
                        break;
                    case "interest" :
                        $interet = $value[$i];
                        break;
                    case "loca" :
                        $loca = $value[$i];
                }
            }
            echo $nick . " - " . $first . " - " . $last . " - " . $mail . " - " . $passwd . " - " . $gender . " - " . $orientation . " - " . $age . " - " . $img . " - " . $interet . " - " . $loca;
            $id = $this->insertFillDB('users', array("nickname"     => $nick,
                                                     "name"        => $first,
                                                     "lastname"    => $last,
                                                     "mail"        => strtolower($mail),
                                                     "passwd"      => $passwd,
                                                     "gender"      => $gender,
                                                     "orientation" => $orientation,
                                                     "age"         => $age));
            $this->insertFillDB('usersImage', array("url"      => "img/" . $img,
                                                    "isprofil" => 1,
                                                    "id_users" => $id));
            $loca = explode(',', $loca);
            $this->insertFillDB('usersLocation', array('longitude' => $loca[1],
                                                       'latitude'  => $loca[0],
                                                       'city'      => $loca[2],
                                                       'id_users'  => $id));
            $interet = explode(',', $interet);
            foreach ($interet as $int)
            {
                $int = trim($int);
                echo "\"SELECT id FROM usersInterest WHERE interest = $int\"";
                $id_interest = $pdo->prepare("SELECT id FROM usersInterest WHERE interest = '$int'");
                $id_interest->execute();
                $idInt = $id_interest->fetch()['id'];
                if($idInt)
                {
                    $this->insertFillDB('users_usersInterest', array('id_users' => $id,
                                                    'id_interest' => $idInt));
                }
                else
                {
                    $idInt = $this->insertFillDB('usersInterest', array('interest' => $int));
                    $this->insertFillDB('users_usersInterest', array('id_users' => $id,
                                                                     'id_interest' => $idInt));

                }
            }


            echo "<br>";

            $i++;
        }
    }

    /*
     *  SPECIAL SQL
     */

    public function addition($id, $col, $int)
    {
        $pdo = $this->app->db->prepare("UPDATE $this->name SET $col = $col + $int WHERE id = ?");
        $pdo->execute(array($id));
    }

    /*
    *	INSERT / UPDATE / DELETE FUNCTION
    */
    public function insertFillDB($name, $values)
    {
        foreach ($values as $key => $v)
        {
            $table[] = $key;
            $int = $int . "?,";
            $val[] = $v;
        }
        $int = $int . "?,";
        $int = $int . "?,";
        $table[] = "created_at";
        $table[] = "updated_at";
        $val[] = date("d/m/Y H:i:s");
        $val[] = date("d/m/Y H:i:s");
        $col = implode(',', $table);
        $int = substr($int, 0, -1);
        $pdo = $this->app->db->prepare("INSERT INTO $name($col) VALUES($int)");
        $pdo->execute($val);

        return $this->app->db->lastInsertId();
    }

    public function insert($values)
    {
        foreach ($values as $key => $v)
        {
            $table[] = $key;
            $int = $int . "?,";
            $val[] = $v;
        }
        $int = $int . "?,";
        $int = $int . "?,";
        $table[] = "created_at";
        $table[] = "updated_at";
        $val[] = date("d/m/Y H:i:s");
        $val[] = date("d/m/Y H:i:s");
        $col = implode(',', $table);
        $int = substr($int, 0, -1);
        $pdo = $this->app->db->prepare("INSERT INTO $this->name($col) VALUES($int)");
        $pdo->execute($val);

        return $this->app->db->lastInsertId();
    }

    public function update($id, $values)
    {
        foreach ($values as $key => $v)
        {
            $table[] = $key . " = ?";
            $val[] = $v;
        }
        $table[] = "updated_at = ?";
        $val[] = date("d/m/Y H:i:s");
        $val[] = $id;
        $col = implode(',', $table);
        $pdo = $this->app->db->prepare("UPDATE $this->name SET $col WHERE id = ?");
        $pdo->execute($val);
    }

    public function updateLink($colonne, $id, $values)
    {
        foreach ($values as $key => $v)
        {
            $table[] = $key . " = ?";
            $val[] = $v;
        }
        $table[] = "updated_at = ?";
        $val[] = date("d/m/Y H:i:s");
        $val[] = $id;
        $col = implode(',', $table);
        $pdo = $this->app->db->prepare("UPDATE $this->name SET $col WHERE $colonne = ?");
        $pdo->execute($val);
    }

    public function deleteSpecial($col, $id)
    {
        $pdo = $this->app->db->prepare("DELETE FROM $this->name WHERE $col = :id");
        $pdo->execute(array(
            'id' => $id
        ));
    }

    public function delete($id)
    {
        $pdo = $this->app->db->prepare("DELETE FROM $this->name WHERE id = :id");
        $pdo->execute(array(
            'id' => $id
        ));

    }

    /*
    *	FIND FUNCTIONS
    */

    public function findById($id)
    {
        $pdo = $this->app->db->prepare("SELECT * FROM $this->name WHERE id = :id");
        $pdo->execute(array(
            'id' => $id
        ));

        return $pdo->fetch();

    }

    public function findOne($col, $id)
    {
        $pdo = $this->app->db->prepare("SELECT * FROM $this->name WHERE $col = :id");
        $pdo->execute(array(
            'id' => $id
        ));

        return $pdo->fetch();
    }

    public function find($col, $id)
    {
        $pdo = $this->app->db->prepare("SELECT * FROM $this->name WHERE $col = :id");
        $pdo->execute(array(
            'id' => $id
        ));

        return $pdo->fetchAll();
    }

    public function findAll()
    {
        $pdo = $this->app->db->prepare("SELECT * FROM $this->name");
        $pdo->execute();

        return $pdo->fetchAll();
    }

    public function findLast()
    {
        $pdo = $this->app->db->prepare("SELECT * FROM $this->name ORDER BY id DESC LIMIT 1");
        $pdo->execute();

        return $pdo->fetch();
    }

    /*
    *  USEFULL FUNCTION
    */

    public function isUnique($col, $value)
    {
        $pdo = $this->app->db->prepare("SELECT $col FROM $this->name WHERE $col = ?");
        $pdo->execute(array($value));
        if (empty($pdo->fetchAll()))
            return true;

        return false;
    }
}

?>