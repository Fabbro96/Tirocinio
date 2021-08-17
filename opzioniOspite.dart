import 'package:app/prenotaOspite.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:postgres/postgres.dart';
import 'prenotaOspite.dart';
import 'visualizzaCorsiOspite.dart';

// ignore: must_be_immutable
class opzioniOspite extends StatefulWidget {
  opzioniOspite({Key? key}) : super(key: key);

  @override
  _opzioniOspite createState() => _opzioniOspite();
}

class _opzioniOspite extends State<opzioniOspite> {
  var _lista = ['Visualizza i corsi', 'Prenota uno shooting'];
  String opzione_selezionata = 'Seleziona una opzione';
  // String text;
  // _visualizzaOpzioniState(this.text);

  void prenotaUnEvento() async {
    await Future.delayed(Duration(seconds: 1));
    Navigator.push(
      context,
      MaterialPageRoute(builder: (context) => prenotaOspite()),
    );
  }

  String totaleCorsi = '';
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
        '''SELECT nome FROM corso''',
      );
      connection.close();
    } catch (e) {
      res = "error";
    }
    if (res.toString().length != 2) {
      res = res.toString().replaceAll('[', '');
      res = res.toString().replaceAll(']', '');
      totaleCorsi = res.toString();
      Navigator.push(
        context,
        MaterialPageRoute(
            builder: (context) => visualizzaCorsiOspite(corso: totaleCorsi)),
      );
    }
  }

  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: Text('Pagina di visualizzazione opzioni'),
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
                      if (opzione_selezionata == "Visualizza i corsi") {
                        visualizzaCorsi(context);
                      } else if (opzione_selezionata ==
                          "Prenota uno shooting") {
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
