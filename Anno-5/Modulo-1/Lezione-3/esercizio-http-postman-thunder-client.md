# 🔢 Lab — HTTP con Postman o Thunder Client di VSC

![Materia](https://img.shields.io/badge/materia-Tecnologia-3DE8A0?style=flat-square)
![Anno](https://img.shields.io/badge/anno-3-3DE8A0?style=flat-square)
![Modulo](https://img.shields.io/badge/modulo-1-3DE8A0?style=flat-square)
![Livello](https://img.shields.io/badge/livello-base-FFAA3D?style=flat-square)

> Laboratorio pratico sull'osservazione delle richieste HTTP, sulle risposte e codici di stato
---

## 🎯 Obiettivi

Al termine del laboratorio sarai in grado di riconoscere

- ✅ metodo HTTP (GET, POST, ecc.);
- ✅ URL;
- ✅ query parameters;
- ✅ request headers;
- ✅ request body;
- ✅ response headers;
- ✅ response body;
- ✅ codici di stato HTTP (200, 201, 400, 404, ecc.).

---



metodo HTTP (GET, POST, ecc.);
URL;
query parameters;
request headers;
request body;
response headers;
response body;
codici di stato HTTP (200, 201, 400, 404, ecc.).

Nota: non è necessario scrivere codice. Useremo delle API pubbliche per concentrarci esclusivamente sull'osservazione del traffico HTTP.

1. Prima richiesta: una semplice GET

Useremo questa API di test:

https://httpbin.org/get

Con Postman
Apri Postman.
Crea una nuova richiesta HTTP.
Seleziona il metodo:
GET

Inserisci:
https://httpbin.org/get

Premi Send.
Con Thunder Client
Apri VS Code.
Installa l'estensione Thunder Client, se non l'hai già fatto.
Crea una nuova richiesta.
Seleziona GET.
Inserisci:
https://httpbin.org/get

Premi Send.
2. Osserviamo la richiesta

Prima di guardare il risultato, prova a rispondere a queste domande:

Domande

A. Qual è il metodo HTTP?

________________________


B. Qual è l'URL richiesto?

________________________


C. La richiesta contiene un body?

Sì / No


D. La richiesta contiene degli header?

Sì / No


Apri la sezione Headers del client e osserva gli header inviati automaticamente.

Potresti trovare header simili a:

Accept: */*
User-Agent: ...


Gli header sono informazioni aggiuntive che accompagnano la richiesta HTTP.

3. Osserviamo la risposta

Dopo aver premuto Send, osserva la risposta.

Dovresti vedere un codice simile a:

200 OK

Cosa significa 200?

Il codice:

200 OK


significa che la richiesta è stata elaborata correttamente.

Osserva anche:

tempo della risposta;
dimensione della risposta;
response headers;
response body.

La risposta contiene informazioni sulla richiesta ricevuta dal server.

4. Request e Response

Possiamo rappresentare quello che è successo così:

CLIENT
  |
  |  GET /get
  |  Headers: ...
  |
  v
SERVER
  |
  |  200 OK
  |  Headers: ...
  |  Body: ...
  |
  v
CLIENT


Questa è l'idea fondamentale del protocollo HTTP:

REQUEST  --->  SERVER
RESPONSE <---  SERVER

5. Aggiungiamo un Query Parameter

Adesso modifica l'URL:

https://httpbin.org/get?nome=Mario&corso=HTTP


Invia nuovamente la richiesta.

Osservazione

La parte:

?nome=Mario&corso=HTTP


è la query string.

Abbiamo due parametri:

nome = Mario
corso = HTTP


In Postman puoi anche inserirli dalla sezione Params, senza scriverli direttamente nell'URL.

Prova a ottenere:

https://httpbin.org/get?nome=Mario&corso=HTTP

Domande
Il metodo HTTP è cambiato?
________________________

Il codice di stato è cambiato?
________________________

Dove puoi vedere i parametri nella risposta?
________________________

Qual è la differenza tra URL e query parameters?
________________________________________________
________________________________________________

6. Osserviamo gli Header

Adesso aggiungiamo manualmente un header.

Nella sezione Headers aggiungi:

X-Studente: Mario


La richiesta sarà concettualmente simile a:

GET /get?nome=Mario&corso=HTTP HTTP/1.1
Host: httpbin.org
X-Studente: Mario


Invia la richiesta.

Cosa osservare?

Controlla la risposta e cerca:

X-Studente


Dovresti vedere che il server ha ricevuto l'header.

Domanda

Perché secondo te gli header sono separati dal body?

Scrivi una tua ipotesi:

________________________________________________
________________________________________________
________________________________________________

7. Request Headers e Response Headers

È importante distinguere due concetti.

Request Headers

Sono gli header inviati dal client al server.

Esempio:

GET /get HTTP/1.1
Host: httpbin.org
Accept: application/json
X-Studente: Mario

Response Headers

Sono gli header inviati dal server al client.

Esempio:

HTTP/1.1 200 OK
Content-Type: application/json
Content-Length: ...


Schema:

CLIENT                         SERVER
  |                              |
  | ---- Request Headers ------> |
  |                              |
  | <---- Response Headers ----- |
  |                              |

8. Seconda richiesta: POST

Adesso facciamo una richiesta che contiene un body.

Usa:

https://httpbin.org/post


Seleziona:

POST


Nel Body seleziona un formato JSON e inserisci:

{
  "nome": "Mario",
  "eta": 20,
  "corso": "HTTP"
}


Invia la richiesta.

9. Osserviamo il POST

Questa volta abbiamo:

POST /post


e un body:

{
  "nome": "Mario",
  "eta": 20,
  "corso": "HTTP"
}


Osserva anche gli header.

Dovresti trovare un header simile a:

Content-Type: application/json

Perché è importante?

Il Content-Type comunica al server il formato dei dati contenuti nel body.

In questo caso:

Content-Type: application/json


significa:

"Il body della richiesta contiene dati JSON."

10. Esercizio: modifica il JSON

Modifica il body inserendo informazioni diverse.

Per esempio:

{
  "nome": "Anna",
  "eta": 25,
  "linguaggio": "JavaScript"
}


Invia la richiesta.

Domande
Qual è il metodo HTTP?
________________________

Qual è il Content-Type?
________________________

Quali dati sono contenuti nel body?
________________________________________________
________________________________________________

Qual è il codice di stato?
________________________

11. Provocare un errore: 404

Ora proviamo a richiedere una risorsa inesistente.

Usa:

https://httpbin.org/status/404


Metodo:

GET


Invia la richiesta.

Dovresti ottenere:

404 NOT FOUND

Cosa significa?

Il codice:

404


significa che la risorsa richiesta non è stata trovata.

È importante capire che:

404 != errore di connessione


Il server ha ricevuto la richiesta e ha risposto.

Semplicemente, la risorsa richiesta non esiste o non è disponibile a quell'URL.

12. Altri codici di stato

Possiamo provare diversi endpoint di httpbin.

200 — OK
https://httpbin.org/status/200


Significa:

La richiesta è stata elaborata correttamente.

201 — Created
https://httpbin.org/status/201


Indica generalmente che una nuova risorsa è stata creata.

400 — Bad Request
https://httpbin.org/status/400


Indica che la richiesta non è valida o non può essere elaborata correttamente.

401 — Unauthorized
https://httpbin.org/status/401


Indica che è richiesta un'autenticazione valida.

403 — Forbidden
https://httpbin.org/status/403


Indica che il server ha rifiutato l'accesso alla risorsa.

404 — Not Found
https://httpbin.org/status/404


La risorsa non è stata trovata.

500 — Internal Server Error
https://httpbin.org/status/500


Indica un errore interno del server.

13. Classificazione dei codici HTTP

I codici HTTP sono divisi in categorie.

Codici	Categoria	Significato generale
1xx	Informativi	Informazioni sulla richiesta
2xx	Successo	Richiesta elaborata correttamente
3xx	Redirezione	Sono necessarie ulteriori azioni
4xx	Errore client	Problema nella richiesta
5xx	Errore server	Problema durante l'elaborazione lato server

Ricorda soprattutto:

2xx → successo
4xx → problema nella richiesta/client
5xx → problema lato server

14. Esercizio finale

Adesso prova a completare questa tabella utilizzando Postman o Thunder Client.

URL	Metodo	Status Code	Request Body	Osservazioni
/get	GET	?	No	
/get?nome=Anna	GET	?	No	
/post	POST	?	JSON	
/status/201	GET	?	No	
/status/400	GET	?	No	
/status/404	GET	?	No	
/status/500	GET	?	No	

Base URL:

https://httpbin.org

15. Mini sfida: analizza una richiesta

Crea questa richiesta:

POST https://httpbin.org/post


Con header:

X-Corso: HTTP
X-Studente: Mario
Content-Type: application/json


E body:

{
  "azione": "test",
  "numero": 42,
  "linguaggio": "JavaScript"
}


Prima di premere Send, prova a prevedere:

Metodo
________________________

URL
________________________

Request headers
________________________
________________________
________________________

Request body
________________________

Status code atteso
________________________


Ora invia la richiesta e confronta le tue risposte con ciò che vedi nel client.

16. Checklist finale

Al termine dell'esercizio dovresti saper identificare:

 metodo HTTP;
 URL;
 query parameters;
 request headers;
 request body;
 response headers;
 response body;
 status code;
 differenza tra 2xx, 4xx e 5xx;
 differenza tra request e response;
 significato di Content-Type;
 differenza tra un errore 4xx e un errore 5xx.
17. Schema riassuntivo

Una richiesta HTTP può essere pensata così:

┌─────────────────────────────────────┐
│              REQUEST                │
├─────────────────────────────────────┤
│ Method: POST                        │
│ URL: https://httpbin.org/post       │
│                                     │
│ Headers:                            │
│   Content-Type: application/json    │
│   X-Studente: Mario                 │
│                                     │
│ Body:                               │
│   {                                 │
│     "nome": "Mario"                 │
│   }                                 │
└──────────────────┬──────────────────┘
                   │
                   ▼
              ┌──────────┐
              │  SERVER  │
              └────┬─────┘
                   │
                   ▼
┌─────────────────────────────────────┐
│             RESPONSE                │
├─────────────────────────────────────┤
│ Status: 200 OK                      │
│                                     │
│ Headers:                            │
│   Content-Type: application/json     │
│                                     │
│ Body:                               │
│   { ... }                           │
└─────────────────────────────────────┘

Concetto fondamentale

Quando usi Postman o Thunder Client, non limitarti a guardare se la risposta "funziona".

Abituati a osservare sempre:

1. Che richiesta sto inviando?
2. Quali header sto inviando?
3. C'è un body?
4. Che risposta ricevo?
5. Qual è lo status code?
6. Quali header restituisce il server?
7. Cosa contiene il response body?


Queste domande costituiscono una buona base per iniziare a comprendere e fare il debug delle API HTTP.