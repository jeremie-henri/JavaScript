<?php
/**
 * Created by PhpStorm.
 * User: h17004901
 * Date: 27/02/19
 * Time: 13:48
 */
session_start();
include "php/PDO.php";
?>
<html lang="fr">
<head>
    <title>Smite Guru 2.0</title>
    <meta name="description" content="Smite guru 2.0 un site internet qui sert a trouver des informations sur les joueurs de smite" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="vegas/vegas.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="icon" href="img/favicon.ico" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
    <script src="vegas/vegas.min.js"></script>
</head>
<body>
</body>
<script>
    $(document).ready(function () {
        function calcTime(offset) {
            var d = new Date();
            var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
            var nd = new Date(utc + (3600000*offset));

            var year = nd.getFullYear();
            var month = (nd.getMonth() < 10) ? '0' + (nd.getMonth() + 1) : (nd.getMonth() + 1);
            var day =  (nd.getDate() < 10) ? "0" + nd.getDate() : nd.getDate();
            var hours = (nd.getHours() < 10) ? "0" + nd.getHours() : nd.getHours();
            var minutes = (nd.getMinutes() < 10) ? "0" + nd.getMinutes() : nd.getMinutes();
            var seconds = (nd.getSeconds() < 10) ? "0"  + nd.getSeconds() : nd.getSeconds();

            return "" + year + month + day + hours + minutes + seconds;
        }
        $("body").vegas({
            slides: [
                { src: "img/5.png" },
                { src: "img/6.jpg" },
                { src: "img/3.jpg" },
                { src: "img/4.jpg" }
            ]
        });
        $.ajax({
            url:'php/is_connected.php'
        }).done(function (data) {
            if (data === false){
                /*form*/
                $('body').append(
                    $('<div class="container" id="container_1" />'),
                ),
                    $('.container').append(
                        $('<h1 id="titre">Smite Guru 2.0</h1>\n'),
                        $('<p>oui c\'est du plagia</p>\n'),
                        $('<form />').append(
                            $('<div class="input-group">').append(
                                $('<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>'),
                                $('<input id="username" type="text" class="form-control" name="username" placeholder="Login">'),
                            ),
                            $('<div class="input-group">').append(
                                $('<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>'),
                                $('<input id="password" type="password" class="form-control" name="password" placeholder="Password">'),

                            ),
                            $('<input  class="btn btn-default" id="btn_login" type="submit" value="S\'identifier" />'),
                            $('<button class="btn btn-default" id="btn_register" >S\'inscrire</button>').click(function () {

                                var username = $('#username').val();
                                var password = $('#password').val();

                                if(username === "" || password === ""){
                                    alert('Veuillez remplire touts les champs');
                                }else{
                                    $.ajax({
                                        type: "POST",
                                        url: 'php/register.php',
                                        data:  {username : username , password : password},
                                        success: function(data){
                                            if (data === 'register') {
                                                alert('Compte créée');
                                                $("#username").val('');
                                                $("#password").val('');
                                            }
                                            else if (data === false){
                                                alert('ce nom d\'utilisateur est deja utilisé');
                                                $("#username").val('');
                                                $("#password").val('');
                                            }
                                        }
                                    }).done(function () {
                                    });
                                    return false;
                                }
                            })
                        ).submit(function () {
                            $.ajax({
                                type: "POST",
                                url: 'php/login.php',
                                data: $(this).serialize(),
                                success: function(data){
                                    if (data === 'login') {
                                        window.location = '/index.php';
                                    }
                                    else if(data == 'vide') {
                                        alert('Veuillez remplire touts les champs');
                                    }else {
                                        alert('Informations invalide');
                                    }
                                }
                            }).done(function () {
                            });
                            return false;
                        })
                    );
            } else{
                $('body').append(
                    $('<button type="button" class="btn btn-dark" id="btn_logout">Deconnexion</button>').click(function () {
                        $.ajax({
                            url: '/php/logout.php',
                        }).done(function () {
                            window.location.reload(true);
                        });
                        return false;
                    }),
                    $('<div class="container" />').append(
                        $('<h1 id="titre2">Smite Guru 2.0</h1>'),
                        $('<form class="form-inline" />').append(
                            $('<input id="searchbar" class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Entrez le pseudo du joueur" aria-label="Search">'),
                        ).submit(function () {
                            let playername = $('#searchbar').val();
                            var timestamp = calcTime(0);
                            $.ajax({
                                url: '/php/search.php',
                                type:"POST",
                                data: { timestamp : timestamp , meta : $(this).serialize() , playername: playername},
                                success: function(meta){
                                    if (meta  === false){
                                        alert('ce joueur n\'existe pas, entrez un pseudo valide');
                                    }else {
                                        $('#player_info').fadeOut(1000);
                                        $('#player_info').remove();
                                        $('body').append(
                                            $('<div class="container-fluid" id="player_info" />').append(
                                                $('<img id="profil_picture" src="'+meta[0]['Avatar_URL']+'" alt="profil picture" class="img-thumbnail">'),
                                                $('<h6>'+meta[0]['Name']+'</h6>'),
                                                $('<div class="container-fluid" id="status" />').append(
                                                    $('<p>'+meta[0]['Personal_Status_Message']+'</p>'),
                                                ),
                                                $('<div class="row" id="info_box" />').append(
                                                    $('<div class="col-sm-4">HoursPlayed : '+meta[0]['HoursPlayed']+'</div>'),
                                                    $('<div class="col-sm-4">Level : '+meta[0]['Level']+'</div>'),
                                                    $('<div class="col-sm-4">Created : '+meta[0]['Created_Datetime']+'</div>'),
                                                ),
                                                $('<div class="row" id="info_box" />').append(
                                                    $('<div class="col-sm-4">Wins : '+meta[0]['Wins']+'</div>'),
                                                    $('<div class="col-sm-4">Losses : '+meta[0]['Losses']+'</div>'),
                                                    $('<div class="col-sm-4">Leaves : '+meta[0]['Leaves']+'</div>'),
                                                ),
                                                $('<div class="row" id="info_box" />').append(
                                                    $('<div class="col-sm-4">MasteryLevel : '+meta[0]['MasteryLevel']+'</div>'),
                                                    $('<div class="col-sm-4">Region : '+meta[0]['Region']+'</div>'),
                                                    $('<div class="col-sm-4">Achievements : '+meta[0]['Total_Achievements']+'</div>'),
                                                ),
                                                $('<div class="row" id="info_box" />').append(
                                                    $('<div class="col-sm-4">Deaths : '+meta['Deaths']+'</div>'),
                                                    $('<div class="col-sm-4">PlayerKills : '+meta['PlayerKills']+'</div>'),
                                                    $('<div class="col-sm-4">AssistedKills : '+meta['AssistedKills']+'</div>'),
                                                ),
                                                $('<div class="row" id="info_box" />').append(
                                                    $('<div class="col-sm-4">DoubleKills : '+meta['DoubleKills']+'</div>'),
                                                    $('<div class="col-sm-4">TripleKills : '+meta['TripleKills']+'</div>'),
                                                    $('<div class="col-sm-4">QuadraKills : '+meta['QuadraKills']+'</div>'),
                                                ),
                                                $('<div class="row" id="info_box" />').append(
                                                    $('<div class="col-sm-4">PentaKills : '+meta['PentaKills']+'</div>'),
                                                    $('<div class="col-sm-4">FirstBloods : '+meta['FirstBloods']+'</div>'),
                                                    $('<div class="col-sm-4">KillingSpree : '+meta['KillingSpree']+'</div>'),
                                                ),
                                                $('<div class="row" id="info_box" />').append(
                                                    $('<div class="col-sm-4">GodLikeSpree : '+meta['GodLikeSpree']+'</div>'),
                                                    $('<div class="col-sm-4">ImmortalSpree : '+meta['ImmortalSpree']+'</div>'),
                                                    $('<div class="col-sm-4">DivineSpree : '+meta['DivineSpree']+'</div>'),
                                                ),
                                                $('<div class="row" id="info_box" />').append(
                                                    $('<div class="col-sm-4">ShutdownSpree : '+meta['ShutdownSpree']+'</div>'),
                                                    $('<div class="col-sm-4">UnstoppableSpree : '+meta['UnstoppableSpree']+'</div>'),
                                                    $('<div class="col-sm-4">RampageSpree : '+meta['RampageSpree']+'</div>'),
                                                ),
                                                $('<div class="row" id="info_box" />').append(
                                                    $('<div class="col-sm-4">FireGiantKills : '+meta['FireGiantKills']+'</div>'),
                                                    $('<div class="col-sm-4">GoldFuryKills : '+meta['GoldFuryKills']+'</div>'),
                                                    $('<div class="col-sm-4">SiegeJuggernautKills : '+meta['SiegeJuggernautKills']+'</div>'),
                                                ),
                                                $('<div class="row" id="info_box" />').append(
                                                    $('<div class="col-sm-4">MinionKills : '+meta['MinionKills']+'</div>'),
                                                    $('<div class="col-sm-4">TowerKills : '+meta['TowerKills']+'</div>'),
                                                    $('<div class="col-sm-4">PhoenixKills : '+meta['PhoenixKills']+'</div>'),
                                                ),
                                                $('<button type="button" id="btn_match" class="btn btn-dark">Afficher l\'historique de matchs</button>').click(function () {
                                                    var timestamp = calcTime(0);
                                                    $.ajax({
                                                            url: '/php/match.php',
                                                            type:"POST",
                                                            data: { timestamp : timestamp , leta : $(this).serialize() , playername: playername},
                                                            success : function (leta) {
                                                                $('#btn_match').remove();
                                                                var jpg = ".jpg";
                                                                var slash = "/";
                                                                if (leta.length === 0){
                                                                    alert("Ce profil est privé");
                                                                    return 0;
                                                                }
                                                                for (var i = 0 ; i < leta.length ; ++i){
                                                                    let src = leta[i]["God"]+jpg;
                                                                    src = src.split('_').join('-');
                                                                    $('#player_info').append(
                                                                        $('<img src="https://static.smite.guru/i/champions/icons/'+src.toLowerCase()+'" id="img_match">'),
                                                                        $('<div class="row" id="info_box" />').append(
                                                                            $('<div class="col-sm-4">'+leta[i]['Queue']+'</div>'),
                                                                            $('<div class="col-sm-4">'+leta[i]['Kills']+slash+leta[i]['Deaths']+slash+leta[i]['Assists']+'</div>'),
                                                                            $('<div class="col-sm-4">'+leta[i]['Win_Status']+'</div>'),
                                                                            $('<div class="col-sm-4">Damages :'+leta[i]['Damage']+'</div>'),
                                                                            $('<div class="col-sm-4">Damage Taken: '+leta[i]['Damage_Taken']+'</div>'),
                                                                            $('<div class="col-sm-4">Healing: '+leta[i]['Healing']+'</div>'),
                                                                            $('<div class="col-sm-4">Surrendered: '+leta[i]['Surrendered']+'</div>'),
                                                                            $('<div class="col-sm-4">Match Time: '+leta[i]['Match_Time']+'</div>'),
                                                                            $('<div class="col-sm-4">Minutes: '+leta[i]['Minutes']+'</div>'),

                                                                            $('<div class="container-fluid" </div>').append(
                                                                                $('<img class="item" src="https://static.smite.guru/i/items/'+leta[i]["ActiveId1"]+jpg+'">'),
                                                                                $('<img class="item" src="https://static.smite.guru/i/items/'+leta[i]["ActiveId2"]+jpg+'">'),
                                                                                $('<img class="item" src="https://static.smite.guru/i/items/'+leta[i]["ItemId1"]+jpg+'">'),
                                                                                $('<img class="item" src="https://static.smite.guru/i/items/'+leta[i]["ItemId2"]+jpg+'">'),
                                                                                $('<img class="item" src="https://static.smite.guru/i/items/'+leta[i]["ItemId3"]+jpg+'">'),
                                                                                $('<img class="item" src="https://static.smite.guru/i/items/'+leta[i]["ItemId4"]+jpg+'">'),
                                                                                $('<img class="item" src="https://static.smite.guru/i/items/'+leta[i]["ItemId5"]+jpg+'">'),
                                                                                $('<img class="item" src="https://static.smite.guru/i/items/'+leta[i]["ItemId6"]+jpg+'">'),
                                                                            ),
                                                                        ),
                                                                        $('<hr color="white">'),
                                                                    )
                                                                }



                                                            }
                                                        }
                                                    ).done(function () {
                                                    });
                                                    return false;
                                                }),
                                            ).hide().fadeIn(1000),
                                        )
                                        console.log(meta[0]["Id"]);
                                    }
                                }
                            }).done(function () {
                                $("#searchbar").val('');
                            });
                            return false;
                        }),
                    ),
                )
            }
        });
    });
</script>
</html>