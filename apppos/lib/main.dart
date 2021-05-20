// main.dart
import 'package:apppos/pos/pos.dart';
import 'package:flutter/material.dart';
void main() => runApp(MyApp());

class MyApp extends StatelessWidget {
  
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
      home: Pos()
    );
  }
}
