import 'dart:convert';

import '../pos/pos.dart';
import 'package:flutter/material.dart';
import 'package:flutter_login/flutter_login.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:dio/dio.dart';
import '../config.dart';

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  
  Future<SharedPreferences> _prefs = SharedPreferences.getInstance();
  /*=========== Login User ==============*/
  Future<String> _authUser(LoginData data) async {
    var dio = Dio();
    var formData = FormData.fromMap({
      'username': data.name,
      'password': data.password,
    });
    try {
      Response response =
          await dio.post('${ip_api}api-login/login', data: formData);
      if (response.data['login'] == 'false') {
        return response.data['msg'];
      } else {
        final SharedPreferences prefs = await _prefs;
        prefs.setInt('login_id', response.data['0']['id']);
        prefs.setString('logindata',jsonEncode(response.data));
        return null;
      }
    } on DioError catch (e) {
      return e.message;
      //return 'Make sure your server runing';
    }
  }

  @override
  void initState() {
    super.initState();
  }

  Widget build(BuildContext context) {
    return FlutterLogin(
      title: 'POS',
      //logo: 'assets/images/icon.png',
      onLogin: _authUser,
      onSignup: _authUser,
      hideForgotPasswordButton: true,
      hideSignUpButton: true,
      onSubmitAnimationCompleted: () {
        Navigator.of(context).pushReplacement(MaterialPageRoute(
          builder: (context) => Pos(),
        ));
      },
      /*onRecoverPassword: _recoverPassword,*/
    );
  }
}
