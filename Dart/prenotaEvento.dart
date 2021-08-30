import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_time_picker_spinner/flutter_time_picker_spinner.dart';
import 'package:postgres/postgres.dart';
// ignore: unused_import
import 'package:flutter_switch/flutter_switch.dart';

// ignore: must_be_immutable
class prenotaEvento extends StatefulWidget {
  final String email_pass;
  prenotaEvento({Key? key, required this.email_pass}) : super(key: key);
  @override
  _prenotaEvento createState() => _prenotaEvento(this.email_pass);
}

class _prenotaEvento extends State<prenotaEvento> {
  final controllerData = TextEditingController();
  final controllerNome = TextEditingController();
  final controllerLuogo = TextEditingController();
  final controllerOrario = TextEditingController();
  DateTime _dateTime = DateTime.now();
  String email_pass;
  bool status = false;
  _prenotaEvento(this.email_pass);

  Future<void> operation(String time) async {
    String dataText = controllerData.text.toString();
    String nomeText = controllerNome.text.toString();
    String luogoText = controllerLuogo.text.toString();
    String orarioText = controllerOrario.text.toString();

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
      String tipologia = "null";
      if (!status)
        tipologia = "privateEvent";
      else
        tipologia = "shooting";
      res = await connection.query('''INSERT INTO evento VALUES (@data, @nome, 
          @luogo, @orario, @tipologia , @email)''', substitutionValues: {
        "data": dataText,
        "nome": nomeText,
        "luogo": luogoText,
        "orario": time,
        "email": email_pass,
        "tipologia": tipologia
      });

      final snackBar = SnackBar(content: Text("Prenotazione effettuata"));
      ScaffoldMessenger.of(context).showSnackBar(snackBar);
      connection.close();
    } catch (e) {
      res = "error";
      final snackBar = SnackBar(
          content: Text(
              "Data e nome dell'evento giá inserito. Si prega di cambiarli."));
      ScaffoldMessenger.of(context).showSnackBar(snackBar);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Pagina per la prenotazione di un evento'),
      ),
      body: SingleChildScrollView(
          child: Column(
        children: <Widget>[
          TextField(
            readOnly: true,
            controller: controllerData,
            decoration: InputDecoration(hintText: 'Data'),
            onTap: () async {
              var date = await showDatePicker(
                  context: context,
                  initialDate: DateTime.now(),
                  firstDate: DateTime(2000),
                  lastDate: DateTime(2100));
              if (date.toString() != 'null')
                controllerData.text = date.toString().substring(0, 10);
              else
                controllerData.text = '';
            },
          ),
          TextField(
            decoration: InputDecoration(hintText: "Nome"),
            autofocus: false,
            obscureText: false,
            controller: controllerNome,
          ),
          TextField(
            decoration: InputDecoration(hintText: "Luogo"),
            autofocus: false,
            obscureText: false,
            //collegamento della label ad una variabile in modo da poi estrapolare il testo
            controller: controllerLuogo,
          ),
          new Text(
            "Orario selezionato:    " +
                _dateTime.hour.toString().padLeft(2, '0') +
                ':' +
                _dateTime.minute.toString().padLeft(2, '0') +
                ':00',
            style: TextStyle(
                fontSize: 20, fontWeight: FontWeight.bold, color: Colors.blue),
          ),

          hourMinute15Interval(),

          //Bottone semplice

          ElevatedButton(
              onPressed: () {
                String stringa = "";
                showDialog(
                    context: context,
                    builder: (context) {
                      if (controllerData.text.isEmpty ||
                          controllerLuogo.text.isEmpty ||
                          controllerNome.text.isEmpty)
                        stringa = "Non tutti i campi sono stati inseriti";
                      else {
                        operation(_dateTime.hour.toString().padLeft(2, '0') +
                            ":" +
                            _dateTime.minute.toString().padLeft(2, '0') +
                            ":00");
                        stringa = "Prenotazione in corso..";
                      }
                      Future.delayed(Duration(seconds: 1), () {
                        Navigator.of(context).pop(true);
                      });
                      return AlertDialog(
                        content: Text(stringa),
                      );
                    });
              },
              child: Text('Prenota')),
          FlutterSwitch(
            activeText: "Shooting",
            inactiveText: "Evento",
            inactiveColor: Colors.brown,
            activeColor: Colors.deepOrange,
            value: status,
            valueFontSize: 10.0,
            width: 110,
            borderRadius: 30.0,
            showOnOff: true,
            onToggle: (val) {
              setState(() {
                status = val;
              });
            },
          ),
          //we will add our widgets here.
        ],
      )),
    );
  }

  Widget hourMinute15Interval() {
    return new TimePickerSpinner(
      spacing: 10,
      minutesInterval: 15,
      isForce2Digits: true,
      onTimeChange: (time) {
        setState(() {
          _dateTime = time;
        });
      },
    );
  }
}
