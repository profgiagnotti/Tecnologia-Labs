# Lab — Gestione dei processi

**Materia:** Tecnologia — Anno 4 — Modulo 1
**Lezione di riferimento:** L01 — Gestione dei processi
**File lezione:** `te-a4-m1-l01-gestione-dei-processi.html`

---

## Obiettivi

- [ ] Distinguere programmi e processi osservando il sistema operativo reale
- [ ] Calcolare a mano le metriche di scheduling per FCFS, SJF e Round Robin
- [ ] Riprodurre e osservare una race condition in un piccolo programma multithread
- [ ] Scrivere ed eseguire un programma C che crea thread in Windows con `CreateThread`

## Prerequisiti

- Un sistema Windows con **Visual Studio** (Community Edition) oppure `gcc`/MinGW installato, per compilare gli esempi in C
- In alternativa: una macchina Linux con `gcc` e la libreria `pthread` per l'esercizio equivalente lato Linux (facoltativo, sezione 4)
- Task Manager (Windows) o `htop`/`top` (Linux) per l'osservazione dei processi

## Indice

1. [Osservare processi e thread nel sistema reale](#1-osservare-processi-e-thread-nel-sistema-reale)
2. [Scheduling — calcolo delle metriche](#2-scheduling--calcolo-delle-metriche)
3. [Programma C — creazione di thread con l'API di Windows](#3-programma-c--creazione-di-thread-con-lapi-di-windows)
4. [Riprodurre una race condition](#4-riprodurre-una-race-condition)
5. [Esercizi di consolidamento](#5-esercizi-di-consolidamento)

---

## 1. Osservare processi e thread nel sistema reale

**Windows**

1. Apri il **Task Manager** (`Ctrl+Shift+Esc`) → scheda **Dettagli**.
2. Individua un processo con più istanze aperte (es. apri due finestre del Blocco Note) e annota i due PID differenti.
3. Passa alla scheda **Prestazioni → CPU**, clic destro → **Apri Gestione risorse**, scheda **CPU**: espandi un processo per vedere i singoli thread che lo compongono e la percentuale di CPU usata da ciascuno.

**Linux (facoltativo)**

```bash
ps -eLf | grep firefox    # elenca i thread (colonna LWP) di un processo firefox
htop                      # premi H per mostrare/nascondere i thread nella vista
```

**Domande guidate**

- Quanti thread ha in media un processo del browser che stai osservando?
- Il PID del processo principale e gli ID dei singoli thread sono uguali o diversi?
- Prova a "congelare" un processo (in Task Manager, tasto destro → Sospendi processo, se disponibile) e osserva in che stato appare: cosa succede alla CPU utilizzata?

---

## 2. Scheduling — calcolo delle metriche

Dato il seguente set di processi, tutti arrivati all'istante 0:

| Processo | Burst time (ms) |
|----------|-----------------|
| P1 | 6 |
| P2 | 8 |
| P3 | 2 |
| P4 | 4 |

Per **ciascuno** dei seguenti algoritmi, calcola: ordine di esecuzione, tempo di attesa di ogni processo, tempo di completamento (turnaround) di ogni processo, tempo medio di attesa.

1. **FCFS** (ordine di arrivo: P1, P2, P3, P4)
2. **SJF** non-preemptive
3. **Round Robin** con quantum = 3 ms

> Suggerimento: costruisci per ognuno un diagramma di Gantt su carta (una riga temporale con i blocchi di esecuzione) prima di calcolare le metriche — aiuta moltissimo a non sbagliare i conti.

**Verifica**: confronta i tre tempi medi di attesa ottenuti. Quale algoritmo è più efficiente in media? Quale garantisce che nessun processo attenda "troppo"? C'è un trade-off tra i due obiettivi?

---

## 3. Programma C — creazione di thread con l'API di Windows

Crea un file `thread_demo.c` con il seguente scheletro e completalo secondo le istruzioni:

```c
#include <windows.h>
#include <stdio.h>

#define NUM_THREAD 4

DWORD WINAPI Worker(LPVOID param) {
    int id = *(int*)param;
    printf("[Thread %d] avviato, ID di sistema: %lu\n", id, GetCurrentThreadId());

    // TODO 1: simula un piccolo lavoro con un ciclo che somma numeri da 1 a 1.000.000
    // TODO 2: stampa il risultato ottenuto insieme all'id del thread

    printf("[Thread %d] terminato\n", id);
    return 0;
}

int main() {
    HANDLE handles[NUM_THREAD];
    int ids[NUM_THREAD];

    for (int i = 0; i < NUM_THREAD; i++) {
        ids[i] = i;
        // TODO 3: crea il thread con CreateThread passando &ids[i] come parametro
    }

    // TODO 4: attendi il completamento di TUTTI i thread con WaitForMultipleObjects

    for (int i = 0; i < NUM_THREAD; i++) {
        CloseHandle(handles[i]);
    }

    printf("Tutti i thread hanno terminato.\n");
    return 0;
}
```

**Compilazione (MinGW):**

```bash
gcc thread_demo.c -o thread_demo.exe -lkernel32
thread_demo.exe
```

**Osservazione richiesta**: esegui il programma 3-4 volte di seguito e osserva l'ordine con cui i messaggi `[Thread N] avviato` compaiono a video. È sempre lo stesso? Perché?

---

## 4. Riprodurre una race condition

Completa questa variante del programma, in cui **tutti i thread incrementano una variabile globale condivisa** senza alcuna sincronizzazione:

```c
#include <windows.h>
#include <stdio.h>

#define NUM_THREAD 4
#define INCREMENTI 1000000

long contatore = 0; // variabile condivisa, NON protetta

DWORD WINAPI Incrementa(LPVOID param) {
    for (int i = 0; i < INCREMENTI; i++) {
        contatore = contatore + 1; // operazione NON atomica
    }
    return 0;
}

int main() {
    HANDLE handles[NUM_THREAD];

    for (int i = 0; i < NUM_THREAD; i++) {
        handles[i] = CreateThread(NULL, 0, Incrementa, NULL, 0, NULL);
    }

    WaitForMultipleObjects(NUM_THREAD, handles, TRUE, INFINITE);

    printf("Valore atteso: %d\n", NUM_THREAD * INCREMENTI);
    printf("Valore ottenuto: %ld\n", contatore);

    for (int i = 0; i < NUM_THREAD; i++) {
        CloseHandle(handles[i]);
    }
    return 0;
}
```

Compila ed esegui più volte. Il "valore ottenuto" corrisponde sempre al "valore atteso"? Annota i risultati di almeno 5 esecuzioni.

**Domanda finale**: sostituisci l'incremento diretto con una versione che usa `InterlockedIncrement(&contatore)` al posto di `contatore = contatore + 1`. Il problema scompare? Perché, secondo te, questa funzione risolve la race condition (cerca il significato di "operazione atomica")?

---

## 5. Esercizi di consolidamento

**A — Scheduling con priorità**

Riprendi la tabella dei 4 processi della sezione 2 e assegna a ciascuno una priorità (1 = più alta, 4 = più bassa): P3=1, P1=2, P4=3, P2=4. Simula lo scheduling a priorità non-preemptive e calcola il tempo medio di attesa. Confrontalo con i risultati precedenti.

**B — Simulatore di scheduling in Python**

Scrivi uno script Python che, dato in input un elenco di processi (nome, burst time, arrival time), calcoli automaticamente tempo di attesa e turnaround per FCFS e SJF, stampando una tabella riepilogativa. Verifica lo script contro i calcoli manuali del punto 2.

**C — Thread pool concettuale**

Senza scrivere codice, rispondi per iscritto (max 15 righe): perché un thread pool è più efficiente della creazione di un nuovo thread per ogni singola richiesta in un server web che deve gestire migliaia di connessioni al secondo? Collega la risposta al concetto di costo del context switch visto in questa lezione.

---

## Checklist finale

- [ ] Ho osservato PID e thread di un processo reale con Task Manager/htop
- [ ] Ho calcolato a mano le metriche di FCFS, SJF e Round Robin sullo stesso set di processi
- [ ] Ho compilato ed eseguito il programma multithread base con `CreateThread`
- [ ] Ho riprodotto e osservato empiricamente una race condition
- [ ] Ho completato almeno due dei tre esercizi di consolidamento

---

**Prossimo lab:** sincronizzazione tra thread — mutex, semafori e sezioni critiche (Tecnologia A4 M1 L02)
