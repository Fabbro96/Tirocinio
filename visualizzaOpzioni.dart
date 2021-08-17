import 'package:app/visualizzaCorsiIscritto.dart';
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
  var _lista = ['Visualizza i corsi a cui sei iscritto', 'Prenota un evento'];
  String opzione_selezionata = 'Seleziona una opzione';
  String text;
  _visualizzaOpzioniState(this.text);

  void prenotaUnEvento() async {
    await Future.delayed(Duration(seconds: 1));
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
    }
  }

  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: Text('Pagina di ' + text),
        ),
        body: SingleChildScrollView(
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
                showDialog(
                    context: context,
                    builder: (context) {
                      String contesto = opzione_selezionata;
                      if (opzione_selezionata ==
                          "Visualizza i corsi a cui sei iscritto") {
                        visualizzaCorsi(context);
                      } else if (opzione_selezionata == "Prenota un evento") {
                        prenotaUnEvento();
                      } else {
                        return AlertDialog(
                          content: Text("Seleziona una opzione valida"),
                        );
                      }
                      return const SizedBox();
                    });
              },
              child: Text("Esegui"))
        ])));
  }
}
