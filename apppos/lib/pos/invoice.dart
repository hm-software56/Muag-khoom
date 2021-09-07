import 'dart:convert';
import 'dart:io';
import 'dart:typed_data';
import 'package:apppos/pos/menu.dart';
import 'package:apppos/pos/pos.dart';
import 'package:apppos/pos/print.dart';
import 'package:charset_converter/charset_converter.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:intl/intl.dart';
import 'package:esc_pos_utils/esc_pos_utils.dart';

//import 'package:network_pos_printer/network_pos_printer.dart';
import 'package:esc_pos_printer/esc_pos_printer.dart';
import 'package:esc_pos_utils/esc_pos_utils.dart';

class Invoice extends StatefulWidget {
  var data_validate;
  var invoiceData;
  List<Map> added_items;
  int discount;
  int price_total;
  var loginData;
  Invoice(this.added_items, this.discount, this.price_total, this.loginData,
      this.data_validate, this.invoiceData);
  @override
  _InvoiceState createState() => _InvoiceState(this.added_items, this.discount,
      this.price_total, this.loginData, this.data_validate, this.invoiceData);
}

class _InvoiceState extends State<Invoice> {
  var data_validate;
  var invoiceData;
  List<Map> added_items;
  int discount;
  int price_total;
  var loginData;
  _InvoiceState(this.added_items, this.discount, this.price_total,
      this.loginData, this.data_validate, this.invoiceData);

  void Donepaid() {
    Alert(Icons.done, Colors.white, 'ສໍາເລັດການຈ່າຍເງີນແລ້ວ.!', Colors.green,
        2500);
  }

/*======== Alert msg ==============*/
  void Alert(
      IconData icon, Color iconcolor, var msg, Color bgcolor, int timeshow) {
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
      duration: Duration(milliseconds: timeshow),
    ));
  }

  Print(var added_items, var invoiceData, var data_validate, var price_total,
      var discount) async {
    final PrinterNetworkManager printerManager = PrinterNetworkManager();
    printerManager.selectPrinter('192.168.100.70', port: 9100);
    final PosPrintResult res = await printerManager.printTicket(
        await PrintRecived(
            added_items, invoiceData, data_validate, price_total, discount));
    print('Print result: ${res.msg}');
  }

  Future<Ticket> PrintRecived(var added_items, var invoiceData,
      var data_validate, var price_total, var discount) async {
    final Ticket ticket = Ticket(PaperSize.mm80);
    ticket.text('Received',
        styles: PosStyles(
          align: PosAlign.center,
          height: PosTextSize.size2,
          width: PosTextSize.size2,
        ));
    ticket.text('No.:${invoiceData['code']}',
        styles: PosStyles(align: PosAlign.right), linesAfter: 1);
    for (var item in added_items) {
      var price=NumberFormat.currency(locale: 'eu', symbol: 'Kip').format(int.parse(item['price']));
      ticket.row([
        PosColumn(
          textEncoded:
              await CharsetConverter.encode("windows1252", item['name']),
          width: 6,
          containsChinese: false,
          styles: PosStyles(
              align: PosAlign.center, codeTable: PosCodeTable.wpc1252_1),
        ),
        PosColumn(
          text: '${item['qautity']}',
          width: 3,
          styles: PosStyles(align: PosAlign.center),
        ),
        PosColumn(
          text: '${price}',
          width: 3,
          styles: PosStyles(align: PosAlign.center),
        ),
      ]);
    }
    ticket.emptyLines(0);
    ticket.row([
      PosColumn(
        text: 'Discount',
        width: 9,
        styles: PosStyles(align: PosAlign.right,reverse: true),
      ),
      PosColumn(
        text: '${NumberFormat.currency(locale: 'eu', symbol: 'LAK').format(discount)}',
        width: 3,
        styles: PosStyles(align: PosAlign.right),
      ),
    ]);
    var total=price_total - discount;
    ticket.row([
      PosColumn(
        text: 'Total',
        width: 9,
        styles: PosStyles(align: PosAlign.right,reverse: true),
      ),
      PosColumn(
        text: '${NumberFormat.currency(locale: 'eu', symbol: 'LAK').format(total)}',
        width: 3,
        styles: PosStyles(align: PosAlign.right),
      ),
    ]);
    ticket.emptyLines(1);
    ticket.row([
      PosColumn(
        text: 'Pay (LAK)',
        width: 9,
        styles: PosStyles(align: PosAlign.left),
      ),
      PosColumn(
        text: '${NumberFormat.currency(locale: 'eu', symbol: 'LAK').format(data_validate['pay_lak']==null?0:data_validate['pay_lak'])}',
        width: 3,
        styles: PosStyles(align: PosAlign.right),
      ),
    ]);
    ticket.row([
      PosColumn(
        text: 'Pay (TH)',
        width: 9,
        styles: PosStyles(align: PosAlign.left),
      ),
      PosColumn(
        text: '${NumberFormat.currency(locale: 'eu', symbol: 'BATH').format(data_validate['pay_th']==null?0:data_validate['pay_th'])}',
        width: 3,
        styles: PosStyles(align: PosAlign.right),
      ),
    ]);
    ticket.row([
      PosColumn(
        text: 'Pay (USD)',
        width: 9,
        styles: PosStyles(align: PosAlign.left),
      ),
      PosColumn(
        text: '${NumberFormat.currency(locale: 'eu', symbol: 'USD').format(data_validate['pay_usd']==null?0:data_validate['pay_usd'])}',
        width: 3,
        styles: PosStyles(align: PosAlign.right),
      ),
    ]);
    final List<int> barData = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 4];
    ticket.barcode(Barcode.upcA(barData));
    ticket.feed(2);
    ticket.cut();
    return ticket;
  }

  GlobalKey<ScaffoldState> _scaffoldKey = GlobalKey<ScaffoldState>();

  @override
  void initState() {
    super.initState();
  }

  Widget build(BuildContext context) {
    print(added_items);
    //Donepaid();
    return Scaffold(
        //key: _scaffoldKey,
        drawer: Menu(loginData),
        appBar: new AppBar(
          title: const Text(
            'ໃບຮັບເງີນ',
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
                        '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(discount)}',
                        style: TextStyle(
                            fontWeight: FontWeight.bold, color: Colors.blue),
                      ))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ລວມ​ຈ​ຳ​ນວນ​ເງ​ີນ​ຕ້ອງ​ຈ່າຍ:')),
                      Expanded(
                          child: Text(
                        '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(price_total - discount)}',
                        style: TextStyle(fontWeight: FontWeight.bold),
                      ))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ(LAK):')),
                      Expanded(
                          child: data_validate['pay_lak'] == null
                              ? Text('0,00 ກີບ')
                              : Text(
                                  '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(data_validate['pay_lak'])}'))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ(TH):')),
                      Expanded(
                          child: data_validate['pay_th'] == null
                              ? Text('0,00 ບາດ')
                              : Text(
                                  '${NumberFormat.currency(locale: 'eu', symbol: 'ບາດ').format(data_validate['pay_th'])}'))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ(USD):')),
                      Expanded(
                          child: data_validate['pay_usd'] == null
                              ? Text('0,00 ໂດລາ')
                              : Text(
                                  '${NumberFormat.currency(locale: 'eu', symbol: 'ໂດລາ').format(data_validate['pay_usd'])}'))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​​ເງີນຄ້າງ:')),
                      Expanded(
                          child: data_validate['pay_still'] == null
                              ? Text('0,00')
                              : Text(
                                  '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(data_validate['pay_still'])}',
                                  style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: Colors.red),
                                ))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​​ເງີນທອນ:')),
                      Expanded(
                          child: data_validate['pay_change'] == null
                              ? Text('0,00')
                              : Text(
                                  '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(data_validate['pay_change'])}',
                                  style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: Colors.green),
                                ))
                    ],
                  ),
                  Divider(
                    color: Colors.green,
                  ),
                  Row(
                    children: [
                      Padding(
                        padding: const EdgeInsets.fromLTRB(8, 0, 8, 0),
                        child: RaisedButton.icon(
                          icon: Icon(Icons.print_rounded),
                          textColor: Colors.white,
                          color: Colors.blue,
                          label: const Text('ພີມໃບບີນ'),
                          onPressed: () {
                            Print(added_items, invoiceData, data_validate,
                                price_total, discount);

                            // testTicket();
                          },
                        ),
                      ),
                      Expanded(
                        child: Text(''),
                      ),
                      Padding(
                        padding: const EdgeInsets.fromLTRB(8, 0, 8, 0),
                        child: Align(
                          alignment: Alignment.bottomRight,
                          child: RaisedButton(
                            onPressed: () {
                              Navigator.pushReplacement(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) => Pos()));
                            },
                            color: Colors.green,
                            textColor: Colors.white,
                            child: Row(
                              children: <Widget>[
                                Icon(Icons.update),
                                Text('ສັ່ງຊື້ໃໝ່')
                              ],
                            ),
                          ),
                        ),
                      )
                    ],
                  ),
                ],
              ),
            ),
          ),
        ));
  }
}
