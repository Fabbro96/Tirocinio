import 'package:app/visualizzaOpzioni.dart';
import 'package:flutter/material.dart';
import "package:postgres/postgres.dart";
import 'dart:async';
import 'package:app/opzioniOspite.dart';

String email = '';
void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  // This widget is the root of your application.

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'LOGIN',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: Home(),
    );
  }
}

class Home extends StatefulWidget {
  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {
  final controllerEmail = TextEditingController();
  final controllerPassword = TextEditingController();
  final controllerProva = TextEditingController();
  final controllerTesto = TextEditingController();
  var res;
  Future<void> operation(BuildContext cont) async {
    String mailtext = controllerEmail.text.toString();
    String passwordtext = controllerPassword.text.toString();
    var connection = PostgreSQLConnection(
        "ec2-54-229-68-88.eu-west-1.compute.amazonaws.com",
        5432,
        "d53jiomn4btlbs",
        username: "vnnfvmmusrzflv",
        password:
            "a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2",
        useSSL: true);
    try {
      await connection.open();
      Navigator.pop(
        cont,
        MaterialPageRoute(builder: (context) => alertDialog()),
      );
      controllerTesto.value = TextEditingValue(text: "NO");
      res = await connection.query(
          '''SELECT email FROM personaiscritta WHERE(email=@email AND password=@password)''',
          substitutionValues: {"email": mailtext, "password": passwordtext});
      if (res.toString() != "[]") {
        res = res.toString().replaceAll('[', '');
        res = res.toString().replaceAll(']', '');
        email = res.toString();
        Navigator.push(
          cont,
          MaterialPageRoute(
              builder: (context) => visualizzaOpzioni(
                    mail_pass: mailtext,
                  )),
        );
      }
      //Messaggio in stile snackBar per segnalare una eventuale email e/o password non corretta
      else {
        final snackBar =
            SnackBar(content: Text("Email e/o password non corretta"));
        ScaffoldMessenger.of(context).showSnackBar(snackBar);
      }

      connection.close();
    } catch (e) {
      res = "error";
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Pagina di Login'),
      ),
      body: SingleChildScrollView(
          child: Column(
        children: <Widget>[
          //TextField per la email
          TextField(
            decoration: InputDecoration(hintText: "Email"),
            autofocus: false,
            obscureText: false,
            //collegamento della label ad una variabile in modo da poi estrapolare il testo
            controller: controllerEmail,
          ),
          //TextField per la password
          TextField(
            decoration: InputDecoration(hintText: "Password"),
            autofocus: false,
            obscureText: true,
            controller: controllerPassword,
          ), //Bottone per il login
          ElevatedButton(
              onPressed: () {
                showDialog(
                    context: context,
                    builder: (context) {
                      String contesto = "Login in corso, prego attendere..";
                      if (controllerEmail.text.isEmpty ||
                          controllerPassword.text.isEmpty) {
                        contesto = "E-Mail o password non inserita";
                      } else {
                        operation(context);
                      }
                      return AlertDialog(
                        content: Text(contesto),
                      );
                    });
              },
              child: Text('Log In')),
          //Bottone per entrare come ospite
          ElevatedButton(
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => opzioniOspite()),
                );
              },
              child: Text('Entra come ospite')),
          //we will add our widgets here.
        ],
      )),
    );
  }
}

class LoginEffettuato extends StatelessWidget {
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Pagine di Login")),
    );
  }
}

class alertDialog extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      title: Text("Success"),
      content: Text("Saved successfully"),
    );
  }
}
