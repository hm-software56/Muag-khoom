import 'package:apppos/config.dart';
import 'package:apppos/login/login.dart';
import 'package:apppos/webview/report.dart';
import 'package:apppos/webview/web.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Menu extends StatefulWidget {
  var loginData;
  Menu(this.loginData);
  @override
  _MenuState createState() => _MenuState(this.loginData);
}

class _MenuState extends State<Menu> {
  var loginData;
  _MenuState(this.loginData);
  /*========== Function User Logout ================*/
  Future<SharedPreferences> _prefs = SharedPreferences.getInstance();
  Future<Null> Logout() async {
    final SharedPreferences prefs = await _prefs;
    prefs.clear();
    /*Navigator.pushReplacement(
        context, MaterialPageRoute(builder: (context) => LoginScreen()));*/
    Navigator.of(context).pushAndRemoveUntil(
      // the new route
      MaterialPageRoute(
        builder: (BuildContext context) => LoginScreen(),
      ),
      (Route route) => false,
    );
  }

  Widget drawer(loginData) {
    return Drawer(
      child: ListView(
        padding: EdgeInsets.zero,
        children: <Widget>[
          UserAccountsDrawerHeader(
            accountName: Text(
                "${loginData['0']['first_name']} ${loginData['0']['last_name']}"),
            accountEmail: Text("${loginData['0']['username']}"),
            decoration: BoxDecoration(
              color: Colors.blue,
            ),
            currentAccountPicture: CircleAvatar(
              backgroundColor: Colors.white,
              child: ClipOval(
                child: CachedNetworkImage(
                  imageUrl: '${ip}/images/thume/${loginData['0']['photo']}',
                  fit: BoxFit.cover,
                  placeholder: (context, url) => CircularProgressIndicator(),
                  errorWidget: (context, url, error) => Icon(Icons.error),
                ),
              ),
            ),
          ),
          ListTile(
            leading: Icon(Icons.dashboard),
            title: Text('ລາຍງານ Dashboard'),
            onTap: () {
              Navigator.push(
                  context, MaterialPageRoute(builder: (context) => Web()));
            },
          ),
          Divider(),
          ListTile(
            leading: Icon(Icons.report),
            title: Text('ລາຍງານການຂາຍ'),
            onTap: () {
              Navigator.push(
                  context, MaterialPageRoute(builder: (context) =>Report()));
            },
          ),
          Divider(),
          ListTile(
            leading: Icon(Icons.logout_rounded),
            title: Text('ອອກຈາກລະບົບ'),
            onTap: () {
              Logout();
              // ...
            },
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return drawer(loginData);
  }
}
