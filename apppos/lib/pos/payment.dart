import 'package:apppos/config.dart';
import 'package:apppos/pos/invoice.dart';
import 'package:apppos/pos/pos.dart';
import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class Payment extends StatefulWidget {
  @override
  List<Map> added_items;
  int discount;
  int price_total;
  var loginData;
  Payment(this.added_items, this.discount, this.price_total, this.loginData);
  _PaymentState createState() => _PaymentState(
      this.added_items, this.discount, this.price_total, this.loginData);
}

class _PaymentState extends State<Payment> {
  List<Map> added_items;
  int discount;
  int price_total;
  var loginData;
  _PaymentState(
      this.added_items, this.discount, this.price_total, this.loginData);
  TextEditingController _LAKFieldController = TextEditingController();
  TextEditingController _THFieldController = TextEditingController();
  TextEditingController _USDFieldController = TextEditingController();

  int LAK_Price = 0;
  int TH_Price = 0;
  int USD_Price = 0;

  void AddcurentDefaultprice(price_total, discount) {
    var price = price_total - discount;
    setState(() {
      _LAKFieldController.text = '${price}';
      _THFieldController.text = '0';
      _USDFieldController.text = '0';
      LAK_Price = price;
    });
  }

  /*=========== Calulate Payment ==============*/
  var data_validate;
  bool loading = true;
  bool done_validate = false;
  Future<String> CalulatePayment() async {
    var dio = Dio();
    var formData = FormData.fromMap({
      'totalprice': price_total,
      'discount': discount,
      'pricelak': LAK_Price,
      'priceth': TH_Price,
      'priceusd': USD_Price,
      'branch_id': loginData['0']['branch_id']
    });
    try {
      Response response =
          await dio.post('${ip_api}api-product/pay', data: formData);
      if (response.data['pay_still'] > 0) {
        Alert(Icons.warning, Colors.white, 'ຈໍານວນເງີນຂອງທ່ານຈ່າຍບໍພໍ.!',
            Colors.red);
      } else {
        done_validate = true;
      }
      setState(() {
        data_validate = response.data;
        loading = false;
        done_validate;
      });
    } on DioError catch (e) {
      return 'Make sure your server runing';
    }
  }
  /**==========Function Confim payment ================= */
  bool waiting_comfirm = false;
  //var invoiceData;
  Future<String> ConfirmPayment() async {
    var dio = Dio();
    var formData = FormData.fromMap({
      'totalprice': price_total,
      'discount': discount,
      'payprice': data_validate['pay_lak'],
      'paypriceth': data_validate['pay_th'],
      'paypriceusd': data_validate['pay_usd'],
      'branch_id': loginData['0']['branch_id'],
      'user_id': loginData['0']['id'],
      'product': added_items
    });
    try {
      Response response =
          await dio.post('${ip_api}api-product/ordercomfirm', data: formData);
      if(response.statusCode==200)
      {
        var invoiceData=response.data;
        Navigator.of(context).pop();
        Navigator.pushReplacement(
        context, MaterialPageRoute(builder: (context) => Invoice(added_items, discount, price_total, loginData,data_validate,invoiceData)));
      }
    } on DioError catch (e) {
      return 'Make sure your server runing';
    }
  }

/*======== Alert msg ==============*/
  void Alert(IconData icon, Color iconcolor, var msg, Color bgcolor) {
    ScaffoldMessenger.of(context).showSnackBar(SnackBar(
      content: Row(
        children: <Widget>[
          Icon(
            icon,
            color: iconcolor,
          ),
          Text(
            msg,
            style: TextStyle(fontFamily: 'Phetsarath OT'),
          ),
        ],
      ),
      backgroundColor: bgcolor,
      duration: Duration(milliseconds: 1500),
    ));
  }

  @override
  void initState() {
    super.initState();
    AddcurentDefaultprice(price_total, discount);
  }

  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: const Text(
            'ຈ່າຍເງີນ',
            style: TextStyle(fontFamily: 'Phetsarath OT'),
          ),
        ),
        body: Container(
          child: Padding(
            padding: EdgeInsets.fromLTRB(10, 10, 10, 10),
            child: SingleChildScrollView(
              child: Column(
                children: [
                  Row(
                    children: [
                      Expanded(child: Text('ລວມຈໍານວນເງິີນທັງໝົດ:')),
                      Expanded(
                          child: Text(
                              '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(price_total)}'))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​ເງ​ີນ​ສ່ວນຫຼຸດ:')),
                      Expanded(
                          child: Text(
                              '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(discount)}'))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ລວມ​ຈ​ຳ​ນວນ​ເງ​ີນ​ຕ້ອງ​ຈ່າຍ:')),
                      Expanded(
                          child: Text(
                              '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(price_total - discount)}'))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ(LAK):')),
                      Expanded(
                        child: TextField(
                          enabled: done_validate ? false : true,
                          keyboardType: TextInputType.number,
                          onChanged: (value) {
                            setState(() {
                              if (value == '') {
                                value = '0';
                              }
                              LAK_Price = int.parse(value);
                            });
                          },
                          controller: _LAKFieldController,
                          decoration: InputDecoration(
                            hintText: "ຈ​ຳ​ນວນ​ເງ​ີນ​",
                          ),
                        ),
                      )
                    ],
                  ),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ(TH):')),
                      Expanded(
                        child: TextField(
                          enabled: done_validate ? false : true,
                          keyboardType: TextInputType.number,
                          onChanged: (value) {
                            setState(() {
                              if (value == '') {
                                value = '0';
                              }
                              TH_Price = int.parse(value);
                            });
                          },
                          controller: _THFieldController,
                          decoration: InputDecoration(
                            hintText: "ຈ​ຳ​ນວນ​ເງ​ີນ​",
                          ),
                        ),
                      )
                    ],
                  ),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ(USD):')),
                      Expanded(
                        child: TextField(
                          enabled: done_validate ? false : true,
                          keyboardType: TextInputType.number,
                          onChanged: (value) {
                            setState(() {
                              if (value == '') {
                                value = '0';
                              }
                              USD_Price = int.parse(value);
                            });
                          },
                          controller: _USDFieldController,
                          decoration: InputDecoration(
                            hintText: "ຈ​ຳ​ນວນ​ເງ​ີນ​",
                          ),
                        ),
                      )
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​​ເງີນຄ້າງ:')),
                      Expanded(
                          child: loading
                              ? Text('0,00 ກີບ',
                                  style: TextStyle(
                                      color: Colors.red,
                                      fontWeight: FontWeight.bold))
                              : data_validate['pay_still'] == null
                                  ? Text(
                                      '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(price_total - discount)}',
                                      style: TextStyle(
                                          color: Colors.red,
                                          fontWeight: FontWeight.bold))
                                  : Text(
                                      '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(data_validate['pay_still'])}',
                                      style: TextStyle(
                                          color: Colors.red,
                                          fontWeight: FontWeight.bold)))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​​ເງີນທອນ:')),
                      Expanded(
                          child: loading
                              ? Text('0,00 ກີບ',
                                  style: TextStyle(
                                      color: Colors.green,
                                      fontWeight: FontWeight.bold))
                              : data_validate['pay_change'] == null
                                  ? Text('0,00 ກີບ',
                                      style: TextStyle(
                                          color: Colors.green,
                                          fontWeight: FontWeight.bold))
                                  : Text(
                                      '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(data_validate['pay_change'])}',
                                      style: TextStyle(
                                          color: Colors.green,
                                          fontWeight: FontWeight.bold)))
                    ],
                  ),
                  Divider(
                    color: Colors.red,
                  ),
                  Align(
                    alignment: Alignment.bottomRight,
                    child: done_validate
                        ? waiting_comfirm
                            ? CircularProgressIndicator()
                            : RaisedButton.icon(
                                icon: Icon(Icons.calculate_outlined),
                                textColor: Colors.white,
                                color: Colors.green,
                                label: const Text('ຢັ້ງຢືນຈ່າຍເງີນ'),
                                onPressed: () {
                                  setState(() {
                                    waiting_comfirm=true;
                                  });
                                  ConfirmPayment();
                                },
                              )
                        : RaisedButton.icon(
                            icon: Icon(Icons.calculate_outlined),
                            textColor: Colors.white,
                            color: Colors.blue,
                            label: const Text('ຄໍານວນ'),
                            onPressed: () {
                              CalulatePayment();
                            },
                          ),
                  ),
                ],
              ),
            ),
          ),
        ));
  }
}
