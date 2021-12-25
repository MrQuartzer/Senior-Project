import 'package:flutter/material.dart';
import 'package:petcareapplication/api_provider.dart';
import 'package:petcareapplication/screen/mainmenu.dart';
import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  TextEditingController _ctrlUsername = TextEditingController();
  TextEditingController _ctrlPassword = TextEditingController();
  final _formKey = GlobalKey<FormState>();

  ApiProvider apiProvider = ApiProvider();

  Future doLogin() async {
    if (_formKey.currentState.validate()) {
      try {
        var rs = await apiProvider.doLogin(_ctrlUsername.text, _ctrlPassword.text);
        if(rs.statusCode == 200) {
          print(rs.body);
          var jsonRes = json.decode(rs.body);

          if (jsonRes['ok']) {
            String token = jsonRes['token'];
            print(token);
            String username = jsonRes['username'];
            print(username);
            SharedPreferences prefs = await SharedPreferences.getInstance();
            await prefs.setString('token', token);
            Navigator.of(context).pushReplacement(MaterialPageRoute(builder: (context) => MainMenuScreen(Username: username)));
          } else {
            print(jsonRes['error']);
          }
        } else {
          print('Server Error!');
        }
      }catch(error) {
        print(error);
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Form(
        key: _formKey,
        child: Stack(
          children: <Widget>[
            Container(
              height: double.infinity,
              width: double.infinity,
              decoration: BoxDecoration(
                  gradient: LinearGradient(
                      begin: Alignment.topCenter,
                      end: Alignment.bottomCenter,
                      colors: [
                    Colors.lightBlue[100],
                    Colors.lightBlue[200],
                    Colors.lightBlue[200],
                    Colors.lightBlue[100],
                  ])),
              child: SingleChildScrollView(
                physics: AlwaysScrollableScrollPhysics(),
                padding: EdgeInsets.symmetric(horizontal: 25, vertical: 120),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: <Widget>[
                    Text(
                      'PET CARE',
                      style: TextStyle(
                          color: Colors.white,
                          fontSize: 40,
                          fontWeight: FontWeight.bold),
                    ),
                    SizedBox(height: 50),
                    TextFormField(
                      style: TextStyle(color: Colors.black87),
                      validator: (value) {
                        if (value.isEmpty) {
                          return 'Please enter username!';
                        }
                      },
                      controller: _ctrlUsername,
                      decoration: InputDecoration(
                          fillColor: Colors.white,
                          filled: true,
                          border: InputBorder.none,
                          contentPadding: EdgeInsets.only(top: 14),
                          prefixIcon: Icon(Icons.account_circle,
                              color: Colors.lightBlue),
                          hintText: 'Username',
                          hintStyle: TextStyle(color: Colors.black38)),
                    ),
                    SizedBox(height: 50),
                    TextFormField(
                      obscureText: true,
                      style: TextStyle(color: Colors.black87),
                      validator: (value) {
                        if (value.isEmpty) {
                          return 'กรุณาใส่รหัสผ่าน!';
                        }
                      },
                      controller: _ctrlPassword,
                      decoration: InputDecoration(
                          fillColor: Colors.white,
                          filled: true,
                          border: InputBorder.none,
                          contentPadding: EdgeInsets.only(top: 14),
                          prefixIcon: Icon(Icons.lock, color: Colors.lightBlue),
                          hintText: 'Password',
                          hintStyle: TextStyle(color: Colors.black38)),
                    ),
                    SizedBox(height: 40),
                    Container(
                      child: Row(
                        children: [
                          Expanded(child: 
                              RaisedButton(
                                elevation: 5,
                                onPressed: () => doLogin(),
                                padding: EdgeInsets.all(15),
                                shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(15)),
                                color: Colors.white,
                                child: Text(
                                  'LOGIN',
                                  style: TextStyle(
                                      color: Colors.lightBlue[200],
                                      fontSize: 18,
                                      fontWeight: FontWeight.bold),
                                ),
                              ),
                          ),
                        ],
                      ),
                    )
                  ],
                ),
              ),
            )
          ],
        ),
      ),
    );
  }
}
