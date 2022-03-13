   

// fonction d'envoi de mesure à l'API en JSON

function sendApi(valeur,session) {

    let preobj =  {
        session_id: session,
        valeur: valeur
      };

    let obj = JSON.stringify(preobj);
    fetch('./API_receiver.php', {
        method: 'POST',
        body: obj,
        headers: {
            'Content-Type': 'application/json',
                    
                    
        }
    }).then(function(response) {
        // return Promise.reject(response);
        console.log(preobj);
    }).then(function(data) {
        console.log(data);
    }).catch(function(error) {
        console.warn('Something went wrong.', error);
        console.log(obj)
    });

    

    

}

//fonction qui récupere la dernière valeur et qui lui ajoute ou retire un nombre compris entre 1 et 3. Puis envoi à L'API.

function randomMesure(session,mod){

    // recuperation de la valeur en localstorage
    let value = localStorage.getItem(`session${session}Value`);


    // Si elle n'est pas définie on lui défini une valeur de base entre 0 et 30.
    if (value == null){
        baseNum =  Math.floor(Math.random() * 30 );
        localStorage.setItem(`session${session}Value`, baseNum );
        value = localStorage.getItem(`session${session}Value`);
    }

    // On défini ensuite un signe pour le nombre qu'on va ajouter à notre valeur
    let randSigne = Math.random();
    if (randSigne >= 0.5){
        signe = "+";
    } else {
        signe = "-";
    }
 

    // On défini un nombre aléatoire qui va devenir la valeur à envoyer
    let number = Math.floor(Math.random() * 3 );

    // Si le nombre est négatif ->
    if (signe == "-"){
        number = parseInt(number - (number*2));
        
    }


    // On additionne les deux variables qu'on enregistre ensuite en localstorage pour la prochaine itération.
    value = parseInt(parseInt(value)+parseInt(number));
    localStorage.setItem(`session${session}Value`, value);



    
    //simulation d'erreurs
    let erreur = Math.floor(Math.random() * 100);
    if (erreur >= 99){
        // erreur faisant passer le module d'état de fonctionnement à état d'erreur
        document.location.href = `state_change.php?id=${mod}&change=1&dir=to`;
    } else if (erreur <=3){
        // erreur faisant que la mesure donne un résultat nul.
        number = null;
    }


    // console.log(number);
    // Envoi de la valeur dans la base de données
    sendApi(value,session);
    // Affichage en temps réel des valeurs dans la zone attribuée
    afficheValeur(value,mod);

    // Ajoute 1 au nombre de mesures affiché à l'écran en  temps réel.
    changeNbMesures(mod);
}


// affichage de la nouvelle valeur en temps réel
function afficheValeur(num,mod){
    document.querySelector(`.m${mod} .valeur`).innerHTML = num;
}

let oldNB = 0;
let zone;
function changeNbMesures(mod){
    zone = document.querySelector(`.m${mod} .nbM`);
    oldNb = parseInt(zone.innerHTML);

    zone.innerHTML = oldNb+1;
}

