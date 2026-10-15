<?php
    $poslato = false;
    $greska = "";
    $ime = "";
    $prezime = "";
    $mejl = "";
    $brojtel = "";
    $poruka = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $ime = trim($_POST["ime"] ?? "");
        $prezime = trim($_POST["prezime"] ?? "");
        $mejl = trim($_POST["mejl"] ?? "");
        $brojtel = trim($_POST["brtl"] ?? "");
        $poruka = trim($_POST["poruka"] ?? "");

        if (
            $ime !== "" &&
            $poruka !== "" &&
            filter_var($mejl, FILTER_VALIDATE_EMAIL) &&
            strlen($ime) <= 400 &&
            strlen($prezime) <= 400 &&
            strlen($mejl) <= 254 &&
            strlen($brojtel) <= 100 &&
            strlen($poruka) <= 20000
        ) {

            // Adrese se podesavaju na PHP serveru.
            $to = getenv("CONTACT_RECIPIENT");
            $from = getenv("CONTACT_SENDER");

            if (
                $to &&
                $from &&
                filter_var($to, FILTER_VALIDATE_EMAIL) &&
                filter_var($from, FILTER_VALIDATE_EMAIL)
            ) {
                $naslov = "Nova poruka sa sajta Steel Plus";
                $sastav = "";
                $sastav .= "Od: " . $ime . " " . $prezime . "\r\n";
                $sastav .= "Email: " . $mejl . "\r\n";
                $sastav .= "Broj telefona: " . $brojtel . "\r\n";
                $sastav .= "Poruka:\r\n" . $poruka . "\r\n";

                $bezbedanMejl = str_replace(array("\r", "\n"),"",$mejl);

                $headers = array("From" => $from,"Reply-To" => $bezbedanMejl,"Content-Type" => "text/plain; charset=UTF-8");

                $poslato = mail($to,$naslov,$sastav,$headers);

                if ($poslato) {
                    $ime = "";
                    $prezime = "";
                    $mejl = "";
                    $brojtel = "";
                    $poruka = "";
                } else {
                    $greska = "Doslo je do greske pri slanju poruke.";
                }

            } else {
                $greska = "Servis za slanje poruka nije konfigurisan.";
            }

        } else {
            $greska = "Proverite unete podatke.";
        }
    }

    function prikazi($vrednost) {
        return htmlspecialchars(
            $vrednost,
            ENT_QUOTES,
            "UTF-8"
        );
    }
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&family=Quicksand&display=swap" rel="stylesheet">
    <title>Kontakt</title>
    <link rel="stylesheet" type="text/css" href="kontakt.css">
</head>
<body>
    <!--Navigacija-->
    <div class="header">
        <nav>
            <a href="S1.html" class="logo">
                <img src="logo.bmp" alt="Steel Plus logo">
            </a>
            <div class="nav-lin">
                <ul>
                    <li><a href="S1.html"> Pocetak </a></li>
                    <li><a href="Projekti.html"> Nasi Projekti </a></li>
                    <li><a href="Onama.html"> O Nama </a></li>
                    <li><a href="Kontakt.php"> Kontakt </a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="box">
        <!--Glavna kutija gde se sve nalazi-->
        <div class="b2">
            <!--Jedna manja kutija da se odvoji forma od ostalog-->
            <div class="poz">
                <div class="form">
                    <h2>Pisite Nam</h2>
                    <?php if ($poslato): ?>
                        <p class="success">
                            Uspesno poslato! Hvala na poruci.
                        </p>
                    <?php endif; ?>
                    <?php if ($greska !== ""): ?>
                        <p class="error">
                            <?php echo prikazi($greska); ?>
                        </p>
                    <?php endif; ?>
                    <form action="Kontakt.php" method="post">
                        <input type="text" name="ime" class="field" placeholder="Ime" maxlength="100" value="<?php echo prikazi($ime); ?>" required/>
                        <input type="text" name="prezime" class="field" placeholder="Prezime" maxlength="100" value="<?php echo prikazi($prezime); ?>"/>
                        <input type="email" name="mejl" class="field" placeholder="E-mail" maxlength="254" value="<?php echo prikazi($mejl); ?>" required/>
                        <input type="tel" name="brtl" class="field" placeholder="Broj telefona" maxlength="30" value="<?php echo prikazi($brojtel); ?>"/>
                        <textarea name="poruka" class="field-area" placeholder="Poruka" maxlength="5000" required><?php echo prikazi($poruka); ?></textarea>
                        <input type="submit" class="field-submit" value="Posalji"/>
                    </form>
                </div>
            </div>
        </div>
        <div class="b2">
            <!--Druga manja kutija za odvajanje-->
            <div class="info">
                <div class="info-b">
                    <h3>Kontakt Info</h3>
                    <div class="ib">
                        <ul>
                            <li>
                                <div class="direktor">
                                    <span>
                                        <ion-icon name="person"></ion-icon>
                                    </span>
                                    <span>Dzon Dou</span>
                                </div>
                            </li>
                            <li>
                                <div class="mejl">
                                    <span>
                                        <ion-icon name="mail"></ion-icon>
                                    </span>
                                    <a href="mailto:loremips@gmail.com">
                                        loremips@gmail.com
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="tel">
                                    <span>
                                        <ion-icon name="call"></ion-icon>
                                    </span>
                                    <a href="tel:+381987654321">
                                        +381 98 765 4321
                                    </a>
                                </div>
                            </li>
                            <li>
                                <!--Socijalne medije-->
                                <ul class="sm">
                                    <li>
                                        <a href="https://www.facebook.com/"
                                           target="_blank"
                                           rel="noopener noreferrer">
                                            <ion-icon name="logo-facebook"></ion-icon>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/"
                                           target="_blank"
                                           rel="noopener noreferrer">
                                            <ion-icon name="logo-linkedin"></ion-icon>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.youtube.com/results?search_query=gradilista"
                                           target="_blank"
                                           rel="noopener noreferrer">
                                            <ion-icon name="logo-youtube"></ion-icon>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/"
                                           target="_blank"
                                           rel="noopener noreferrer">
                                            <ion-icon name="logo-twitter"></ion-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <br>

            <div class="map">
                <div class="map-b">
                    <iframe
                        src="https://www.google.com/maps?q=44.7795084,20.4688857&output=embed"
                        title="Steel Plus lokacija"
                        style="border:0;"
                        allowfullscreen
                        loading="lazy">
                    </iframe>

                </div>
            </div>
        </div>
    </div>

    <script
        type="module"
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js">
    </script>

    <script
        nomodule
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js">
    </script>

</body>
</html>