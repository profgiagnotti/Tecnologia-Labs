# Laboratorio – Convertitori tra basi numeriche in Python

## Obiettivo
- Comprendere il funzionamento dei sistemi di numerazione (decimale, binario, ottale, esadecimale)
- Costruire funzioni Python per convertire numeri tra basi diverse
- Conoscere e saper usare le funzioni built-in di Python dedicate alle conversioni
- Capire la logica matematica dietro un algoritmo di conversione, senza affidarsi solo alle funzioni pronte

## Prerequisiti
- Python 3 installato (o un interprete online, es. replit.it)
- Editor di testo o IDE (es. VS Code, Thonny, PyCharm)
- Conoscenza base di variabili, cicli `while`/`for` e liste

---

## Parte 1 – Le basi numeriche: un ripasso veloce

Un numero in base *b* è composto da cifre che vanno da 0 a *b-1*.

| Base | Nome | Cifre valide |
|------|------|--------------|
| 2    | Binario | 0, 1 |
| 8    | Ottale | 0–7 |
| 10   | Decimale | 0–9 |
| 16   | Esadecimale | 0–9, A–F |

Esempio: il numero decimale `13` si scrive:
- in binario: `1101`
- in ottale: `15`
- in esadecimale: `D`

Domande:
- Perché in esadecimale servono le lettere A-F?
- Quante cifre binarie servono per rappresentare il numero decimale 255?

---

## Parte 2 – Usare le funzioni built-in di Python

Python offre funzioni pronte per convertire un numero decimale in altre basi:

'bin(13)'    # '0b1101'

'oct(13)'    # '0o15'

'hex(13)'    # '0xd'


Per il percorso inverso (da stringa a numero decimale), si usa `int()` specificando la base:

'int('1101', 2)'   # 13

'int('15', 8)'     # 13

'int('d', 16)'     # 13


Domande:
- Cosa rappresentano i prefissi `0b`, `0o`, `0x` restituiti da `bin()`, `oct()`, `hex()`?
- Come si rimuove il prefisso dal risultato di `bin()`?

---

## Parte 3 – Costruire un convertitore da decimale a binario "a mano"

Obiettivo: capire l'algoritmo delle divisioni successive, senza usare `bin()`.

Algoritmo:
1. Dividere il numero per 2
2. Annotare il resto (0 o 1)
3. Aggiornare il numero con il quoziente
4. Ripetere finché il numero non è 0
5. Leggere i resti dal basso verso l'alto

Codice guida:

'''python
def decimale_a_binario(n):
    if n == 0:
        return "0"
    cifre = []
    while n > 0:
        resto = n % 2
        cifre.append(str(resto))
        n = n // 2
    cifre.reverse()
    return "".join(cifre)

print(decimale_a_binario(13))  # 1101
'''

Funzioni usate:
- `n % 2`: operatore modulo, restituisce il resto della divisione (0 o 1)
- `n // 2`: divisione intera, restituisce il quoziente senza decimali
- `list.append()`: aggiunge un elemento in coda alla lista
- `list.reverse()`: inverte l'ordine degli elementi nella lista
- `"".join(lista)`: unisce gli elementi di una lista di stringhe in un'unica stringa

Domande:
- Perché è necessario invertire l'ordine dei resti alla fine?
- Cosa succederebbe se non si gestisse il caso speciale `n == 0`?

---

## Parte 4 – Generalizzare: convertitore da decimale a base qualsiasi

Estendiamo la funzione precedente per funzionare con qualunque base tra 2 e 16.

'''python
def decimale_a_base(n, base):
    cifre_valide = "0123456789ABCDEF"
    if n == 0:
        return "0"
    risultato = []
    while n > 0:
        resto = n % base
        risultato.append(cifre_valide[resto])
        n = n // base
    risultato.reverse()
    return "".join(risultato)

print(decimale_a_base(13, 2))   # 1101
print(decimale_a_base(13, 8))   # 15
print(decimale_a_base(13, 16))  # D
'''

Funzioni e concetti usati:
- `cifre_valide[resto]`: indicizzazione di una stringa per ricavare il carattere corrispondente al resto (utile quando il resto supera 9, es. 10 → 'A')
- Parametro `base`: rende la funzione riutilizzabile per qualsiasi sistema di numerazione, non solo binario

Domande:
- Perché serve una stringa `cifre_valide` invece di convertire direttamente il resto in stringa con `str()`?
- Come modificheresti la funzione per supportare basi maggiori di 16?

---

## Parte 5 – Convertitore da una base qualsiasi a decimale

Ora il percorso inverso: da una stringa in base *b* al valore decimale.

Metodo: moltiplicare ogni cifra per la base elevata alla posizione (partendo da destra, posizione 0).

'''python
def base_a_decimale(numero_str, base):
    cifre_valide = "0123456789ABCDEF"
    numero_str = numero_str.upper()
    risultato = 0
    for cifra in numero_str:
        valore_cifra = cifre_valide.index(cifra)
        risultato = risultato * base + valore_cifra
    return risultato

print(base_a_decimale("1101", 2))  # 13
print(base_a_decimale("15", 8))    # 13
print(base_a_decimale("D", 16))    # 13
'''

Funzioni e concetti usati:
- `str.upper()`: converte le lettere in maiuscolo, per gestire sia `"d"` che `"D"`
- `str.index(carattere)`: trova la posizione di un carattere in una stringa (qui usata per ricavarne il valore numerico)
- `risultato = risultato * base + valore_cifra`: tecnica dello "schema di Horner", equivalente a scorrere le cifre da sinistra a destra moltiplicando via via per la base

Domande:
- Prova a calcolare a mano, passo per passo, cosa succede eseguendo `base_a_decimale("101", 2)`
- Perché questo metodo non richiede di invertire nessuna lista, a differenza della Parte 3?

---

## Parte 6 – Convertitore completo (base a base qualsiasi)

Combinando le due funzioni precedenti si può convertire da qualunque base a qualunque altra base, passando per il decimale come "ponte" intermedio.

'''python
def converti(numero_str, base_partenza, base_arrivo):
    valore_decimale = base_a_decimale(numero_str, base_partenza)
    return decimale_a_base(valore_decimale, base_arrivo)

print(converti("1101", 2, 16))  # D  (da binario a esadecimale)
print(converti("FF", 16, 2))    # 11111111
'''

Domanda di riflessione:
- Perché conviene sempre passare dal decimale invece di scrivere una funzione diretta per ogni coppia di basi (es. binario→esadecimale)?

---

## Parte 7 – Mettere alla prova il programma

Crea un piccolo menu interattivo che chieda all'utente il numero, la base di partenza e la base di arrivo:

'''python
numero = input("Inserisci il numero: ")
base_partenza = int(input("Base di partenza: "))
base_arrivo = int(input("Base di arrivo: "))

print(f"Risultato: {converti(numero, base_partenza, base_arrivo)}")
'''

Funzioni usate:
- `input()`: legge una stringa da tastiera
- f-string (`f"..."`): permette di inserire variabili direttamente dentro una stringa

---

## Domande finali

- Qual è la differenza tra usare le funzioni built-in (`bin`, `oct`, `hex`, `int`) e scrivere l'algoritmo manualmente?
- In quali situazioni reali (informatica, reti, elettronica) si usano conversioni tra basi numeriche?
- Come modificheresti il programma per gestire anche numeri negativi?
- Cosa succede se l'utente inserisce una cifra non valida per la base scelta (es. "2" in base binaria)? Come potresti gestire l'errore?
