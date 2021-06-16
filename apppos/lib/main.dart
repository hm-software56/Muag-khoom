// main.dart
import 'package:apppos/login/screen.dart';
import 'package:apppos/pos/pos.dart';
import 'package:apppos/test_print.dart';
import 'package:apppos/webview/web.dart';
import 'package:flutter/material.dart';
void main() => runApp(MyApp());

class MyApp extends StatelessWidget {
   final List<Map<String, dynamic>> data = [
    {
      'title': 'Produk 1',
      'price': 10000,
      'qty': 2,
      'total_price': 20000,
    },
    {
      'title': 'Produk 2',
      'price': 20000,
      'qty': 2,
      'total_price': 40000,
    },
    {
      'title': 'Produk 3',
      'price': 12000,
      'qty': 1,
      'total_price': 12000,
    },
  ];
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'POS',
      theme: ThemeData(
        primarySwatch: Colors.blue,
        accentColor: Colors.orange,
        cursorColor: Colors.orange,
        textTheme: TextTheme(
          headline3: TextStyle(
            fontFamily: 'Phetsarath OT',
            fontSize: 45.0,
            color: Colors.orange,
          ),
          button: TextStyle(
            fontFamily: 'Phetsarath OT',
          ),
          subtitle1: TextStyle(fontFamily: 'Phetsarath OT'),
          bodyText2: TextStyle(fontFamily: 'Phetsarath OT'),
        ),
      ),
      /*routes: {
        '/login': (context) => LoginScreen(),
        '/pos': (context) => pos(),
      },*/
      home:Pos()
    );
  }
}
