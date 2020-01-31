import 'package:flutter/material.dart';
import 'package:flutter_webview_plugin/flutter_webview_plugin.dart';
import 'package:webview_flutter/webview_flutter.dart';
class Web extends StatefulWidget {
  @override
  _WebState createState() => _WebState();
}

class _WebState extends State<Web> {
  @override
  Widget build(BuildContext context) {
    return WebviewScaffold(
          url: "http://192.168.100.167:8080",
          withJavascript: true,
          withLocalStorage: true,
          resizeToAvoidBottomInset : true,
          
    );
  }
}
