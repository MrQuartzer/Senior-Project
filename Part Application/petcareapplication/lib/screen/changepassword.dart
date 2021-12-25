import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:petcareapplication/api_provider.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:crypto/crypto.dart' as crypto;

class ChangePassworsScreen extends StatefulWidget {
  @override
  _ChangePassworsScreenState createState() => _ChangePassworsScreenState();

  final String sendUsername;
  ChangePassworsScreen({this.sendUsername});
}

class _ChangePassworsScreenState extends State<ChangePassworsScreen> {
  TextEditingController _ctrlCurrentPassword = TextEditingController();
  TextEditingController _ctrlNewPassword = TextEditingController();
  TextEditingController _ctrlConfirmPassword = TextEditingController();
  final _formKey = GlobalKey<FormState>();
  String oldPassword;

  ApiProvider apiProvider = ApiProvider();

  Future updatePassword() async {
    String oldpass = oldPassword;
    var currentpassword = new Utf8Encoder().convert(_ctrlCurrentPassword.text);
    var md5 = crypto.md5;
    var currentpass = md5.convert(currentpassword);

    if (oldpass == currentpass.toString()) {
      var newpassword = new Utf8Encoder().convert(_ctrlNewPassword.text);
      var confirmpassword =
          new Utf8Encoder().convert(_ctrlConfirmPassword.text);
      var md5 = crypto.md5;
      var newpass = md5.convert(newpassword);
      var confirmpass = md5.convert(confirmpassword);
      if (newpass.toString() == confirmpass.toString()) {
        if (_formKey.currentState.validate()) {
          try {
            SharedPreferences pref = await SharedPreferences.getInstance();
            String token = pref.getString('token');
            var rs = await apiProvider.updatePassword(
                token, widget.sendUsername, newpass.toString());
            if (rs.statusCode == 200) {
              print(rs.body);
              var jsonRes = jsonDecode(rs.body);

              if (jsonRes['ok']) {
                Navigator.of(context).pop(true);
              } else {
                print(jsonRes['error']);
              }
            } else {
              print('Server error!');
            }
          } catch (error) {
            print(error);
          }
        }
      } else {
        print('confirmpass not match');
      }
    } else {
      print("not match");
    }
  }

  Future getInfo() async {
    try {
      SharedPreferences pref = await SharedPreferences.getInstance();
      String token = pref.getString('token');
      String sendUsername = widget.sendUsername;

      var rs = await apiProvider.getInfo(token, sendUsername);

      if (rs.statusCode == 200) {
        print(rs.body);
        var jsonRes = jsonDecode(rs.body);

        if (jsonRes['ok']) {
          setState(() {
            oldPassword = jsonRes['info']['customerpassword'];
          });
        } else {
          print(jsonRes['error']);
        }
      } else {
        print('Server error!');
      }
    } catch (error) {
      print(error);
    }
  }

  @override
  void initState() {
    super.initState();
    getInfo();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("เปลี่ยนรหัสผ่าน"),
      ),
      body: Container(
        child: Padding(
          padding: const EdgeInsets.all(20),
          child: Form(
              key: _formKey,
              child: Column(
                children: [
                  Text(
                    "รหัสผ่านปัจจุบัน",
                    style: TextStyle(fontSize: 20),
                  ),
                  TextFormField(
                    obscureText: true,
                    style: TextStyle(color: Colors.black87),
                    validator: (value) {
                      if (value.isEmpty) {
                        return 'กรุณาใส่รหัสผ่านปัจจุบัน!';
                      }
                    },
                    controller: _ctrlCurrentPassword,
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
                  Text(
                    "รหัสผ่านใหม่",
                    style: TextStyle(fontSize: 20),
                  ),
                  TextFormField(
                    obscureText: true,
                    style: TextStyle(color: Colors.black87),
                    validator: (value) {
                      if (value.isEmpty) {
                        return 'กรุณาใส่รหัสผ่านใหม่!';
                      }
                    },
                    controller: _ctrlNewPassword,
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
                  Text(
                    "ยืนยันรหัสผ่านใหม่",
                    style: TextStyle(fontSize: 20),
                  ),
                  TextFormField(
                    obscureText: true,
                    style: TextStyle(color: Colors.black87),
                    validator: (value) {
                      if (value.isEmpty) {
                        return 'กรุณายืนยันรหัสผ่านใหม่!';
                      }
                    },
                    controller: _ctrlConfirmPassword,
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
                  SizedBox(
                    child: ElevatedButton(
                        child: Text(
                          "เปลี่ยนรหัสผ่าน",
                          style: TextStyle(fontSize: 20),
                        ),
                        onPressed: () => updatePassword()),
                  )
                ],
              )),
        ),
      ),
    );
  }
}
