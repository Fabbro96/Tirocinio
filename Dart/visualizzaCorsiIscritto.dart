import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class visualizzaCorsiIscritto extends StatelessWidget {
  final String corso;

  visualizzaCorsiIscritto({Key? key, required this.corso}) : super(key: key);
  final controller = TextEditingController;
  var corsi;
  var size;
  void splitta() {
    corsi = corso.split(",");
    size = corsi.length;
  }

  @override
  Widget build(BuildContext context) {
    splitta();
    return Scaffold(
      appBar: AppBar(title: Text("Lista dei corsi a cui sei iscritto")),
      body: ListView.separated(
        padding: const EdgeInsets.all(8),
        itemCount: size,
        itemBuilder: (BuildContext context, int index) {
          return Container(
            height: 50,
            color: Colors.amber[500],
            child: Center(child: Text('${corsi[index]}')),
          );
        },
        separatorBuilder: (BuildContext context, int index) => const Divider(),
      ),
    );
  }
}
