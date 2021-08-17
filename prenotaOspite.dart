import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_time_picker_spinner/flutter_time_picker_spinner.dart';
import 'package:postgres/postgres.dart';

class prenotaOspite extends StatefulWidget {
  prenotaOspite({Key? key}) : super(key: key);
  @override
  _prenotaOspite createState() => _prenotaOspite();
}

class _prenotaOspite extends State<prenotaOspite> {
  final controllerData = TextEditingController();
  final controllerNome = TextEditingController();
  final controllerLuogo = TextEditingController();
  final controllerOrario = TextEditingController();
  DateTime _dateTime = DateTime.now();

  Future<void> operation() async {
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
      res = await connection.query('''INSERT INTO evento VALUES (@data, @nome, 
          @luogo, @orario, 'shooting', 'ospite')''', substitutionValues: {
        "data": dataText,
        "nome": nomeText,
        "luogo": luogoText,
        "orario": orarioText
      });
      final snackBar = SnackBar(content: Text("Prenotazione effettuata"));
      ScaffoldMessenger.of(context).showSnackBar(snackBar);
      connection.close();
    } catch (e) {
      res = "error";
      final snackBar = SnackBar(
          content: Text(
              "Data e/o nome dell'evento giá inserito. Si prega di cambiarli/o."));
      ScaffoldMessenger.of(context).showSnackBar(snackBar);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Prenotazione di un evento Privato'),
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

          TextField(
            readOnly: true,
            controller: controllerOrario,
            decoration: InputDecoration(
                hintText: 'Schiaccia qui per confermare l\'orario'),
            onTap: () async {
              controllerOrario.text =
                  ('${_dateTime.hour.toString().padLeft(2, '0')}:${_dateTime.minute.toString().padLeft(2, '0')}:00');
            },
          ),

          hourMinute15Interval(),
          //Bottone semplice
          ElevatedButton(
              onPressed: () {
                showDialog(
                    context: context,
                    builder: (context) {
                      if (controllerData.text.isEmpty ||
                          controllerLuogo.text.isEmpty ||
                          controllerNome.text.isEmpty ||
                          controllerOrario.text.isEmpty)
                        return AlertDialog(
                          content:
                              Text("Non tutti i campi sono stati inseriti"),
                        );
                      else {
                        operation();
                        print(controllerOrario.text.toString());
                        Future.delayed(Duration(seconds: 1), () {
                          Navigator.of(context).pop(true);
                        });
                        return AlertDialog(
                          content: Text("Inserimento in corso.."),
                        );
                      }
                    });
              },
              child: Text('Prenota lo shooting'))
          //we will add our widgets here.
        ],
      )),
    );
  }

  Widget hourMinute15Interval() {
    return new TimePickerSpinner(
      spacing: 10,
      minutesInterval: 15,
      onTimeChange: (time) {
        setState(() {
          _dateTime = time;
        });
      },
    );
  }
}
