import 'package:apppos/pos/pos.dart';
import 'package:apppos/webview/web.dart';
import 'package:flutter/material.dart';

class Screen extends StatefulWidget {
  @override
  _ScreenState createState() => _ScreenState();
}

class _ScreenState extends State<Screen> {
  int _count = 0;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
          child: Row(
        children: [
          Expanded(
              child: Center(
                  child: SizedBox.fromSize(
            size: Size(120, 120), // button width and height
            child: ClipOval(
              child: Material(
                color: Colors.blue, // button color
                child: InkWell(
                  splashColor: Colors.green, // splash color
                  onTap: () {
                    Navigator.of(context).pushReplacement(MaterialPageRoute(
                      builder: (context) => Pos(),
                    ));
                  }, // button pressed
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: <Widget>[
                      Icon(Icons.add_shopping_cart), // icon
                      Text("POS",
                          style:
                              TextStyle(fontWeight: FontWeight.bold)), // text
                    ],
                  ),
                ),
              ),
            ),
          ))),
          Expanded(
              child: Center(
                  child: SizedBox.fromSize(
            size: Size(120, 120), // button width and height
            child: ClipOval(
              child: Material(
                color: Colors.green, // button color
                child: InkWell(
                  splashColor: Colors.green, // splash color
                  onTap: () {
                    Navigator.of(context).pushReplacement(MaterialPageRoute(
                      builder: (context) => Web(),
                    ));
                  }, // button pressed
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: <Widget>[
                      Icon(Icons.pie_chart_sharp), // icon
                      Text(
                        "BACKEND",
                        style: TextStyle(fontWeight: FontWeight.bold),
                      ), // text
                    ],
                  ),
                ),
              ),
            ),
          ))),
        ],
      )),
    );
  }
}
