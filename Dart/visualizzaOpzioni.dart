import 'package:app/visualizzaCorsiIscritto.dart';
import 'package:app/visualizzaOrari.dart';
import 'statoPagamenti.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:postgres/postgres.dart';
import 'prenotaEvento.dart';

// ignore: must_be_immutable
class visualizzaOpzioni extends StatefulWidget {
  final String mail_pass;
  visualizzaOpzioni({Key? key, required this.mail_pass}) : super(key: key);

  @override
  _visualizzaOpzioniState createState() =>
      _visualizzaOpzioniState(this.mail_pass);
}

class _visualizzaOpzioniState extends State<visualizzaOpzioni> {
  var _lista = [
    'Visualizza i corsi a cui sei iscritto',
    'Prenota un evento',
    'Visualizza orari',
    'Stato dei tuoi pagamenti'
  ];
  String opzione_selezionata = 'Seleziona una opzione';
  String text;
  _visualizzaOpzioniState(this.text);

  void prenotaUnEvento() async {
    await Future.delayed(Duration(milliseconds: 10));
    Navigator.push(
      context,
      MaterialPageRoute(builder: (context) => prenotaEvento(email_pass: text)),
    );
  }

  String corsi = '';
  Future<void> visualizzaCorsi(BuildContext cont) async {
    var connection = PostgreSQLConnection(
        "ec2-54-229-68-88.eu-west-1.compute.amazonaws.com",
        5432,
        "d53jiomn4btlbs",
        username: "vnnfvmmusrzflv",
        password:
            "a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2",
        useSSL: true);
    var res;
    try {
      await connection.open();
      res = await connection.query(
          '''SELECT nome_corso FROM frequenza_corso_persona WHERE(email_persona = @email)''',
          substitutionValues: {"email": text});
      connection.close();
    } catch (e) {
      res = "error";
    }
    if (res.toString().length != 2) {
      res = res.toString().replaceAll('[', '');
      res = res.toString().replaceAll(']', '');
      corsi = res.toString();
      Navigator.push(
        context,
        MaterialPageRoute(
            builder: (context) => visualizzaCorsiIscritto(
                  corso: res.toString(),
                )),
      );
    } else {
      final snackBar =
          SnackBar(content: Text("Non sei iscritto a nessun corso"));
      ScaffoldMessenger.of(context).showSnackBar(snackBar);
    }
  }

  Future<void> listaOrario(BuildContext cont) async {
    var connection = PostgreSQLConnection(
        "ec2-54-229-68-88.eu-west-1.compute.amazonaws.com",
        5432,
        "d53jiomn4btlbs",
        username: "vnnfvmmusrzflv",
        password:
            "a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2",
        useSSL: true);
    var resNome, resGiorno;
    String orari = '';
    String nomi = '', giorni = '';
    try {
      await connection.open();
      resNome = await connection.query(
          '''SELECT nome FROM timetable_corso JOIN frequenza_corso_persona ON
                (timetable_corso.nome=frequenza_corso_persona.nome_corso)
                WHERE (email_persona = @email)''',
          substitutionValues: {"email": text});
      resGiorno = await connection.query(
          '''SELECT giorno FROM timetable_corso JOIN frequenza_corso_persona ON
                (timetable_corso.nome=frequenza_corso_persona.nome_corso)
                WHERE (email_persona = @email)''',
          substitutionValues: {"email": text});
      connection.close();
    } catch (e) {
      resNome = "error";
    }
    if (resNome.toString().length != 2) {
      resNome = resNome.toString().replaceAll('[', '');
      resNome = resNome.toString().replaceAll(']', '');
      resGiorno = resGiorno.toString().replaceAll('[', '');
      resGiorno = resGiorno.toString().replaceAll(']', '');
      // orari = resNome.toString();
      giorni = resGiorno.toString();
      nomi = resNome.toString();
      var giorniSplit, nomiSplit;
      giorniSplit = giorni.split(',');
      nomiSplit = nomi.split(',');
      String orari = "";
      print(nomiSplit.length);
      for (int i = 0; i < nomiSplit.length; i++) {
        orari += giorniSplit[i].trim() + ": " + nomiSplit[i].trim();
        if (i < nomiSplit.length - 1) orari += ';';
      }
      print(orari);
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => visualizzaOrari(orario: orari)),
      );
    } else {
      final snackBar = SnackBar(
          content: Text("Non ho trovato nessun orario relativo ai corsi"));
      ScaffoldMessenger.of(context).showSnackBar(snackBar);
    }
  }

  Future<void> pagamenti(BuildContext cont) async {
    var resMese, resBool;
    var connection = PostgreSQLConnection(
        "ec2-54-229-68-88.eu-west-1.compute.amazonaws.com",
        5432,
        "d53jiomn4btlbs",
        username: "vnnfvmmusrzflv",
        password:
            "a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2",
        useSSL: true);
    String bool = '', mese = '';
    try {
      await connection.open();
      resBool = await connection.query(
          '''SELECT haPagato FROM pagamentomensile_persona 
                WHERE (email = @email AND anno='2021')''',
          substitutionValues: {"email": text});
      resMese = await connection.query(
          '''SELECT mese FROM pagamentomensile_persona 
                WHERE (email = @email AND anno='2021')''',
          substitutionValues: {"email": text});
      connection.close();
    } catch (e) {
      resMese = "error";
    }
    if (resMese.toString().length != 2) {
      resMese = resMese.toString().replaceAll('[', '');
      resMese = resMese.toString().replaceAll(']', '');
      resBool = resBool.toString().replaceAll('[', '');
      resBool = resBool.toString().replaceAll(']', '');
      bool = resBool.toString();
      mese = resMese.toString();
      var boolSplit, meseSplit;
      boolSplit = bool.split(',');
      meseSplit = mese.split(',');
      String totale = "";
      for (int i = 0; i < meseSplit.length; i++) {
        if (boolSplit[i] == true)
          boolSplit[i] = "Sí";
        else
          boolSplit[i] = "No";
        totale += "Hai pagato nel mese di " +
            meseSplit[i].trim() +
            "? " +
            boolSplit[i];
        if (i < meseSplit.length - 1) totale += ';';
      }
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => statoPagamenti(text: totale)),
      );
    } else {
      final snackBar =
          SnackBar(content: Text("Non ho trovato nessun pagamento"));
      ScaffoldMessenger.of(context).showSnackBar(snackBar);
    }
  }

  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: Text('Pagina per la selezione'),
        ),
        body: SingleChildScrollView(
            child: Center(
                child: Column(children: <Widget>[
          DropdownButton(
            items: _lista.map((String a) {
              return DropdownMenuItem(value: a, child: Text(a));
            }).toList(),
            onChanged: (_valore) => {
              setState(() {
                opzione_selezionata = _valore.toString();
              })
            },
            hint: Text(opzione_selezionata),
          ),
          ElevatedButton(
              onPressed: () {
                if (opzione_selezionata ==
                    "Visualizza i corsi a cui sei iscritto") {
                  visualizzaCorsi(context);
                } else if (opzione_selezionata == "Prenota un evento") {
                  prenotaUnEvento();
                } else if (opzione_selezionata == "Visualizza orari") {
                  listaOrario(context);
                } else if (opzione_selezionata == "Stato dei tuoi pagamenti") {
                  pagamenti(context);
                } else if (opzione_selezionata == "Seleziona una opzione") {
                  final snackBar = SnackBar(
                      content: Text("Non hai selezionato nessuna opzione"));
                  ScaffoldMessenger.of(context).showSnackBar(snackBar);
                }
              },
              child: Text("Esegui"))
        ]))));
  }
}
