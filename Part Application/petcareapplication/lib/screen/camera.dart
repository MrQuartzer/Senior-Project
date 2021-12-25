import 'package:flutter/material.dart';
import 'package:webview_flutter/webview_flutter.dart';
import 'dart:async';
import 'package:petcareapplication/api_provider.dart';

class CameraScreen extends StatefulWidget {
  @override
  _CameraScreenState createState() => _CameraScreenState();

  final String viewcamera;
  CameraScreen({this.viewcamera});
}

class _CameraScreenState extends State<CameraScreen> {
  Completer<WebViewController> _controller = Completer<WebViewController>();

  ApiProvider apiProvider = ApiProvider();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("ดูสัตว์เลี้ยง"),
      ),
      body: WebView(
        initialUrl: "http://${widget.viewcamera}",
        onWebViewCreated: (WebViewController webViewController) {
          _controller.complete(webViewController);
        },
      ),
    );
  }
}