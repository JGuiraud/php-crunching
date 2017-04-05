<?php
$string = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH);
$dico = explode("\n", $string);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>




<!-- //////// Exceptions ////////////  -->

<h2>Exercices</h2>
<!-- //////////////// -->

<p>- Combien de mots contient ce dictionnaire ?</p>
<?php
    echo 'il y a '.sizeof($dico).' mots dans le dictionnaire.';
?>

<!-- //////////////// -->

<p>- Combien de mots font exactement 15 caractères ?</p>

<?php
$quinze = [];
foreach ($dico as $word) {
    if(strlen($word) == 15) {
        array_push($quinze, $word);
    }
}
    // var_dump($quinze);
    echo 'il y a '.sizeof($quinze).' mots qui font exactement 15 caractères.';
?>

<!-- //////////////// -->

<p>- Combien de mots contiennent la lettre « w » ?</p>
<?php

$w = [];
foreach($dico as $word) {
    $varcount = substr_count($word, 'w');
    if ($varcount == 1) {
        array_push($w, $word);
    }
}
echo 'Il y a '.count($w).' qui contiennent la lettre "w".';

?>

<!-- //////////////// -->

<p>- Combien de mots finissent par la lettre « q » ?</p>
<?php
$q = [];
    foreach ($dico as $word) {
        if(substr($word, -1) == 'q') {
            array_push($q, $word);
        }
    }
    // var_dump($quinze);
    echo 'il y a '.sizeof($q).' mots qui finissent par la lettre "q".';

?>

<hr>
<!-- //////////////////////////// FILMS  //////// -->

<h2>Exercices films</h2>

<p>- Exceptions:</p>

<?php

$string = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
$brut
 = json_decode($string, true);
$top = $brut["feed"]["entry"];

$decoded = json_decode($string);

function test($x) {
    if (!$x === null) {
        throw new Exception("something'wrong");
    } else {
        echo "Everything's fine with the JSON. It's the right format.";
    }
}

try {
    echo test($decoded);
} catch(Exception $e){
    echo 'Execption reçue :', $e->getMessage();
}


?>

<p>- Afficher le top10 des films (avec utilisation des execptions)</p>

<ol>

<?php

try {
    foreach ($top as $key => $value) {
        if ($key >= 10)
            throw new Exception ("It's above 10");
         else
            $movie = $value["im:name"]["label"];
            echo '<li>'.$movie.'</li>' ;
        }
    }

    catch (Exception $e) {
        echo 'Caught Exception: ', $e->getMessage();
    }


?>
</ol>

<!-- //////////////// -->

<p>- Quel est le classement du film « Gravity » ?</p>

<?php
$movies = [];
foreach ($top as $key => $value) {
        $movie = $value["im:name"]["label"];
        array_push($movies, $movie);
}
        $posGrav = array_search("Gravity", $movies);
        echo 'Gravity est '.$posGrav.'ème.';
?>

<!-- //////////////// -->

<p>- Quel est le réalisateur du film « The LEGO Movie » ?</p>

<?php

$film = "The LEGO Movie";
$movies2 = [];
$directors = [];
foreach ($top as $key => $value) {
    $movie = $value["im:name"]["label"];
    array_push($movies2, $movie);
}
    $posFilm = array_search($film, $movies);

foreach ($top as $key => $value) {
    $director = $value["im:artist"]["label"];
    array_push($directors, $director);
}
    echo 'Le(s) réalisateur(s) de '.$film.' est(sont) '.$directors[$posFilm].'.';

?>

<!-- //////////////// -->

<p>- Combien de films sont sortis avant 2000 ?</p>

<?php
$releaseDate;
$dates = [];
foreach ($top as $key => $value) {
    $releaseDate = $value["im:releaseDate"]["label"][0];
    array_push($dates, $releaseDate);
}


$before2000 = [];
foreach ($dates as $date) {
    if($date == 1){
        array_push($before2000, $date);
    }
}


 echo sizeof($before2000).' films sont sortis avant 2000.';


?>

<!-- //////////////// -->

<p>- Quel est le film le plus récent ? Le plus vieux ?</p>
<?php
$allDates = [];
foreach ($top as $key => $value) {
    $releaseDate = $value["im:releaseDate"]["label"];
    $dateFour = substr($releaseDate, 0, 4);
    array_push($allDates, $dateFour);
}

echo 'Le film le plus récent date de '.(max($allDates)).'. Le film le plus vieux date de '.(min($allDates)).'.';

?>

<!-- //////////////// -->

<p>- Quelle est la catégorie de films la plus représentée ?</p>

<?php

$categories = [];
foreach ($top as $key => $value) {
    $category = $value["category"]["attributes"]["label"];
    array_push($categories, $category);
}
sort($categories);
$countedCat = (array_count_values($categories));
array_multisort($countedCat);

end($countedCat);
$key = key($countedCat);
echo 'La catégorie de films la plus représentée est : '.($key);

?>

<!-- //////////////// -->

<p>- Quel est le réalisateur le plus présent dans le top100 ?</p>

<?php

$directorsHundred = [];
foreach ($top as $key => $value) {
    $director = $value["im:artist"]["label"];
    array_push($directorsHundred, $director);
}
sort($directorsHundred);
$directorsHundred = (array_count_values($directorsHundred));
array_multisort($directorsHundred);

end($directorsHundred);
$key2 = key($directorsHundred);
echo 'Le réalisateur le plus présent dans le top 100 est : '.($key2);

?>

<!-- //////////////// -->

<p>- Combien cela coûterait-il d'acheter le top10 sur iTunes ? de le louer ?</p>

<?php

$priceAchat;
$priceRent;

foreach ($top as $key => $value) {
    if ($key <10 ){
    $priceAchat += $value["im:price"]["attributes"]["amount"];
    $priceRent += $value["im:rentalPrice"]["attributes"]["amount"];
    }
}

echo 'Il couterait $'.$priceAchat.' pour acheter le top10 sur itunes. Et il couterait $'.$priceRent.' pour louer le top10 sur itunes.';

?>

<!-- //////////////// -->

<p>- Quel est le mois ayant vu le plus de sorties au cinéma ?</p>

<?php
$allMonth = [];
foreach ($top as $keys => $value) {
    $releaseMonth = $value["im:releaseDate"]["label"];
    setlocale(LC_TIME, "fr_FR.utf8");
    $releaseMonth = strftime("%B", strtotime($releaseMonth));
    array_push($allMonth, $releaseMonth);
}
array_multisort($countedMonths);
$countedMonths = array_count_values($allMonth);
$maxs = array_keys($countedMonths, max($countedMonths));
if (sizeof($maxs) > 1) {
    echo 'Le(s) mois ayant vu le plus de sorties au cinéma est(sont) ';
        for ($y = 0; $y < sizeof($maxs); $y++) {
            echo $maxs[$y].', ';
        }
}

?>

<!-- //////////////// -->

<p>- Quels sont les 10 meilleurs films à voir en ayant un budget limité ?</p>

<?php
$cheapestPrices = [];
// $posPrices = [];
foreach ($top as $keys => $value) {
    $pricesToBuy = $value["im:price"]["attributes"]["amount"];
    array_push($cheapestPrices, $pricesToBuy);
}
sort($cheapestPrices);

usort($top, 'compare');
echo '<<ul>';
foreach ($top as $key => $value) {
    if ($key < 10) {
        $movie = $value["im:name"]["label"];
        echo '<li>'.$movie.' : '. $value["im:price"]["attributes"]["amount"].'</li>' ;
    }
}

function compare($film1, $film2){
    if ($film1["im:price"]["attributes"]["amount"] == $film2["im:price"]["attributes"]["amount"]){
        if ($film1["im:rentalPrice"]["attributes"]["amount"] == $film2["im:rentalPrice"]["attributes"]["amount"]) {
            return 0;
        }
        return ($film1["im:rentalPrice"]["attributes"]["amount"] < $film2["im:rentalPrice"]["attributes"]["amount"] ? -1 : 1);
    }
    return ($film1["im:price"]["attributes"]["amount"] < $film2["im:price"]["attributes"]["amount"] ? -1 : 1);
}

echo '</ul>';


// $tabPrice = [];
// $tabClass = [];
// $tabTitle = [];
// foreach ($top as $key => $value) {
//     $tabPrice[] = substr($value['im:price']['label'], 1);
//     $tabClass[] = $key;
//     $tabTitle[] = $value['im:name']['label'];
// }
// array_multisort($tabPrice, SORT_ASC, $tabClass, SORT_NUMERIC, $tabTitle);
// for($i = 0; $i < 10; $i++) {
//     echo '<br>n°: '.$tabClass[$i].' - '.$tabTitle[$i].': $'.$tabPrice[$i];
// }
// echo '<hr>';

?>

<hr>




</body>
</html>