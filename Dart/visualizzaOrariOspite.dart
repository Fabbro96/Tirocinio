import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class visualizzaOrariOspite extends StatelessWidget {
  final String orario;

  visualizzaOrariOspite({Key? key, required this.orario}) : super(key: key);
  final controller = TextEditingController;
  var orari;
  var size;
  void splitta() {
    orari = orario.split(";");
    size = orari.length;
  }

  @override
  Widget build(BuildContext context) {
    splitta();
    return Scaffold(
      appBar: AppBar(title: Text("Lista degli orari")),
      body: ListView.separated(
        padding: const EdgeInsets.all(8),
        itemCount: size,
        itemBuilder: (BuildContext context, int index) {
          return Container(
            height: 50,
            color: Colors.green[800],
            child: Center(child: Text('${orari[index]}')),
          );
        },
        separatorBuilder: (BuildContext context, int index) => const Divider(),
      ),
    );
  }
}
