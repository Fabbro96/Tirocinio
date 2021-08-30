import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class statoPagamenti extends StatelessWidget {
  final String text;

  statoPagamenti({Key? key, required this.text}) : super(key: key);
  final controller = TextEditingController;
  var totale;
  var size;
  void splitta() {
    totale = text.split(";");
    size = totale.length;
  }

  @override
  Widget build(BuildContext context) {
    splitta();
    return Scaffold(
      appBar: AppBar(title: Text("Stato dei pagamenti")),
      body: ListView.separated(
        padding: const EdgeInsets.all(8),
        itemCount: size,
        itemBuilder: (BuildContext context, int index) {
          return Container(
            height: 50,
            color: Colors.blue[700],
            child: Center(child: Text('${totale[index]}')),
          );
        },
        separatorBuilder: (BuildContext context, int index) => const Divider(),
      ),
    );
  }
}
