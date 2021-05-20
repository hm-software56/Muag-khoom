/* JavaScript Virtual Keyboard (numpad variant), version 2.7
 *
 * Copyright (C) 2006-2008 Dmitriy Khudorozhkov (mailto:dmitrykhudorozhkov@yahoo.com)
 *
 * This software is provided "as-is", without any express or implied warranty.
 * In no event will the author be held liable for any damages arising from the
 * use of this software.
 *
 * Permission is granted to anyone to use this software for any purpose,
 * including commercial applications, and to alter it and redistribute it
 * freely, subject to the following restrictions:
 *
 * 1. The origin of this software must not be misrepresented; you must not
 *    claim that you wrote the original software. If you use this software
 *    in a product, an acknowledgment in the product documentation would be
 *    appreciated but is not required.
 *
 * 2. Altered source versions must be plainly marked as such, and must not be
 *    misrepresented as being the original software.
 *
 * 3. This notice may not be removed or altered from any source distribution.
 */

function VNumpad(container_id, callback_ref, font_name, font_size,
                   font_color, bg_color, key_color, border_color,
                   show_click, click_font_color, click_bg_color,
                   click_border_color, do_embed, do_gap)
{
  return this._construct(container_id, callback_ref, font_name, font_size,
                         font_color, bg_color, key_color, border_color,
                         show_click, click_font_color, click_bg_color,
                         click_border_color, do_embed, do_gap);
}

VNumpad.kbArray = [];

VNumpad.prototype = {

  _setup_event: function(elem, eventType, handler)
  {
    return (elem.attachEvent ? elem.attachEvent("on" + eventType, handler) : ((elem.addEventListener) ? elem.addEventListener(eventType, handler, false) : null));
  },

  _start_flash: function(in_el)
  {
    function getColor(str, posOne, posTwo)
    {
      if(/rgb\((\d+),\s(\d+),\s(\d+)\)/.exec(str)) // try to detect Mozilla-style rgb value.
      {
        switch(posOne)
        {
          case 1: return parseInt(RegExp.$1, 10);
          case 2: return parseInt(RegExp.$2, 10);
          case 3: return parseInt(RegExp.$3, 10);
          default: return 0;
        }
      }
      else // standard (#xxxxxx or #xxx) way
        return str.length == 4 ? parseInt(str.substr(posOne, 1) + str.substr(posOne, 1), 16) : parseInt(str.substr(posTwo, 2), 16);
    }

    function getR(color_string)
    { return getColor(color_string, 1, 1); }

    function getG(color_string)
    { return getColor(color_string, 2, 3); }

    function getB(color_string)
    { return getColor(color_string, 3, 5); }

    var el = in_el.time ? in_el : (in_el.company && in_el.company.time ? in_el.company : null);
    if(el)
    {
      el.time = 0;
      clearInterval(el.timer);
    }

    var vkb = this;
    var ftc = vkb.fontcolor, bgc = vkb.keycolor, brc = vkb.bordercolor;

    // Special fixes for simple/dead/modifier keys:

    if(in_el.dead)
      ftc = vkb.deadcolor;

    if(((in_el.innerHTML == "Shift") && vkb.Shift) || ((in_el.innerHTML == "Caps") && vkb.Caps) || ((in_el.innerHTML == "AltGr") && vkb.AltGr))
      bgc = vkb.lic;

    // Extract base color values:
    var fr = getR(ftc), fg = getG(ftc), fb = getB(ftc);
    var kr = getR(bgc), kg = getG(bgc), kb = getB(bgc);
    var br = getR(brc), bg = getG(brc), bb = getB(brc);

    // Extract flash color values:
    var f_r = getR(vkb.cfc), f_g = getG(vkb.cfc), f_b = getB(vkb.cfc);
    var k_r = getR(vkb.cbg), k_g = getG(vkb.cbg), k_b = getB(vkb.cbg);
    var b_r = getR(vkb.cbr), b_g = getG(vkb.cbr), b_b = getB(vkb.cbr);

    var _shift_colors = function()
    {
      function dec2hex(dec)
      {
        var hexChars = "0123456789ABCDEF";
        var a = dec % 16;
        var b = (dec - a) / 16;

        return hexChars.charAt(b) + hexChars.charAt(a) + "";
      }

      in_el.time = !in_el.time ? 10 : (in_el.time - 1);

      function calc_color(start, end)
      { return (end - (in_el.time / 10) * (end - start)); }

      var t_f_r = calc_color(f_r, fr), t_f_g = calc_color(f_g, fg), t_f_b = calc_color(f_b, fb);
      var t_k_r = calc_color(k_r, kr), t_k_g = calc_color(k_g, kg), t_k_b = calc_color(k_b, kb);
      var t_b_r = calc_color(b_r, br), t_b_g = calc_color(b_g, bg), t_b_b = calc_color(b_b, bb);

      in_el.style.color = "#" + dec2hex(t_f_r) + dec2hex(t_f_g) + dec2hex(t_f_b);
      in_el.style.borderColor = "#" + dec2hex(t_b_r) + dec2hex(t_b_g) + dec2hex(t_b_b);
      in_el.style.backgroundColor = "#" + dec2hex(t_k_r) + dec2hex(t_k_g) + dec2hex(t_k_b);

      if(!in_el.time)
      {
        clearInterval(in_el.timer);
        return;
      }
    };

    _shift_colors();

    in_el.timer = window.setInterval(_shift_colors, 50);
  },

  _setup_style: function(obj, top, left, width, height, position, border_color, bg_color, text_align, line_height, font_size, font_weight, padding_left, padding_right)
  {
    var os = obj.style;

    if(top)    os.top = top;
    if(left)   os.left = left;
    if(width)  os.width = width;
    if(height) os.height = height;

    if(position) os.position = position;

    if(border_color) os.border = "1px solid " + border_color;
    if(bg_color) os.backgroundColor = bg_color;

    if(text_align)  os.textAlign  = text_align;
    if(line_height) os.lineHeight = line_height;
    if(font_size)   os.fontSize   = font_size;

    os.fontWeight = font_weight || "bold";

    if(padding_left)  os.paddingLeft  = padding_left;
    if(padding_right) os.paddingRight = padding_right;
  },

  _setup_key: function(parent, id, top, left, width, height, border_color, bg_color, text_align, line_height, font_size, font_weight, padding_left, padding_right)
  {
    var _id = this.Cntr.id + id;
    var exists = document.getElementById(_id);

    var key = exists ? exists.parentNode : document.createElement("DIV");
    this._setup_style(key, top, left, width, height, "absolute");

    var key_sub = exists || document.createElement("DIV");
    key.appendChild(key_sub); parent.appendChild(key);

    this._setup_style(key_sub, "", "", "", line_height, "relative", border_color, bg_color, text_align, line_height, font_size, font_weight, padding_left, padding_right);
    key_sub.id = _id;

    if(!exists) this._setup_event(key_sub, 'mouseup', this._generic_callback_proc);

    return key_sub;
  },

  _findX: function(obj)
  { return (obj && obj.parentNode) ? parseFloat(obj.parentNode.offsetLeft) : 0; },

  _findY: function(obj)
  { return (obj && obj.parentNode) ? parseFloat(obj.parentNode.offsetTop) : 0; },

  _findW: function(obj)
  { return (obj && obj.parentNode) ? parseFloat(obj.parentNode.offsetWidth) : 0; },

  _findH: function(obj)
  { return (obj && obj.parentNode) ? parseFloat(obj.parentNode.offsetHeight) : 0; },

  _construct: function(container_id, callback_ref, font_name, font_size, font_color, bg_color, key_color, border_color,
                       show_click, click_font_color, click_bg_color, click_border_color, do_embed, do_gap)
  {
    var exists  = (this.Cntr != undefined), ct = exists ? this.Cntr : document.getElementById(container_id);
    var changed = (font_size && (font_size != this.fontsize));

    this._Callback = ((typeof(callback_ref) == "function") && ((callback_ref.length == 1) || (callback_ref.length == 2))) ? callback_ref : (this._Callback || null);

    var ff = font_name || this.fontname || "";
    var fs = font_size || this.fontsize || "14px";

    var fc = font_color   || this.fontcolor   || "#000";
    var bg = bg_color     || this.bgcolor     || "#FFF";
    var kc = key_color    || this.keycolor    || "#FFF";
    var bc = border_color || this.bordercolor || "#777";

    this.cfc = click_font_color   || this.cfc || "#CC3300";
    this.cbg = click_bg_color     || this.cbg || "#FF9966";
    this.cbr = click_border_color || this.cbr || "#CC3300";

    this.sc = (show_click == undefined) ? ((this.sc == undefined) ? false : this.sc) : show_click;
    this.gap = (do_gap != undefined) ? (do_gap ? 1 : -1) : (this.gap || 1);

    this.fontname = ff, this.fontsize = fs, this.fontcolor = fc;
    this.bgcolor = bg,  this.keycolor = kc, this.bordercolor = bc;

    if(!exists)
    {
      this.Cntr = ct, this.LastKey = null;

      VNumpad.kbArray[container_id] = this;
    }

    var kb = exists ? ct.childNodes[0] : document.createElement("DIV");

    if(!exists)
    {
      ct.appendChild(kb);
      ct.style.display = "block";
      ct.style.zIndex  = 999;

      if(do_embed)
        ct.style.position = "relative";
      else
      {
        ct.style.position = "absolute";

        var initX = 0, initY = 0, ct_ = ct;
        if(ct_.offsetParent)
        {
          while (ct_.offsetParent)
          {
            initX += ct_.offsetLeft;
            initY += ct_.offsetTop;

            ct_ = ct_.offsetParent;
          }
        }
        else if (ct_.x)
        {
          initX += ct_.x;
          initY += ct_.y;
        }

        ct.style.top = initY + "px", ct.style.left = initX +"px";
      }
 
      kb.style.position = "relative";
      kb.style.top      = "0px", kb.style.left = "0px";
    }

    kb.style.border = "1px solid " + bc;

    var kb_main = exists ? kb.childNodes[0] : document.createElement("DIV"), ks = kb_main.style;
    if(!exists)
    {
      kb.appendChild(kb_main);

      ks.position = "relative";
      ks.width    = "1px";
      ks.cursor   = "default";
    }

    // Disable content selection:
    this._setup_event(kb_main, "selectstart", function(event) { return false; });
    this._setup_event(kb_main, "mousedown",   function(event) { if(event.preventDefault) event.preventDefault(); return false; });

    ks.fontFamily = ff, ks.backgroundColor = bg;

    if(!exists || changed)
    {
      ks.width  = this._create_numpad(container_id, kb_main);
      ks.height = (this._findY(this.LastKey) + this._findH(this.LastKey) + this.gap) + "px";
    }

    return this;
  },

  _create_numpad: function(container_id, parent)
  {
    var c = "center", n = "normal", l = "left", gap = this.gap;
    var fs = this.fontsize, kc = this.keycolor, bc = this.bordercolor;

    var mag = parseFloat(fs) / 14.0, cell = Math.floor(25.0 * mag);
    var dcell = 2 * cell, dp = (dcell + 1) + "px", dp2 = (dcell - 1 - ((gap < 0) ? 2 : 0)) + "px";
    var cp = String(cell) + "px", lh = String(Math.floor(cell - 2.0)) + "px";

    var edge = gap + "px";

    var kb_pad_eur = this._setup_key(parent, "___pad_eur", gap + "px", edge, cp, cp, bc, kc, c, lh, fs);
    kb_pad_eur.innerHTML = "&#x20AC;";

    var edge_1 = (this._findX(kb_pad_eur) + this._findW(kb_pad_eur) + gap) + "px";

    var kb_pad_slash = this._setup_key(parent, "___pad_slash", gap + "px", edge_1, cp, cp, bc, kc, c, lh, fs);
    kb_pad_slash.innerHTML = "/";

    var edge_2 = (this._findX(kb_pad_slash) + this._findW(kb_pad_slash) + gap) + "px";

    var kb_pad_star = this._setup_key(parent, "___pad_star", gap + "px", edge_2, cp, cp, bc, kc, c, lh, fs);
    kb_pad_star.innerHTML = "*";

    var edge_3 = (this._findX(kb_pad_star) + this._findW(kb_pad_star) + gap) + "px";

    var kb_pad_minus = this._setup_key(parent, "___pad_minus", gap + "px", edge_3, cp, cp, bc, kc, c, lh, fs);
    kb_pad_minus.innerHTML = "-";

    this.kbpM = this._findX(kb_pad_minus) + this._findW(kb_pad_minus) + gap;

    var prevH = this._findH(kb_pad_eur), edge_Y = (this._findY(kb_pad_eur) + prevH + gap) + "px";

    var kb_pad_7 = this._setup_key(parent, "___pad_7", edge_Y, edge, cp, cp, bc, kc, c, lh, fs);
    kb_pad_7.innerHTML = "7";

    var kb_pad_8 = this._setup_key(parent, "___pad_8", edge_Y, edge_1, cp, cp, bc, kc, c, lh, fs);
    kb_pad_8.innerHTML = "8";

    var kb_pad_9 = this._setup_key(parent, "___pad_9", edge_Y, edge_2, cp, cp, bc, kc, c, lh, fs);
    kb_pad_9.innerHTML = "9";

    var kb_pad_plus = this._setup_key(parent, "___pad_plus", edge_Y, edge_3, cp, dp, bc, kc, c, dp2, fs);
    kb_pad_plus.innerHTML = "+";

    edge_Y = (this._findY(kb_pad_7) + prevH + gap) + "px";

    var kb_pad_4 = this._setup_key(parent, "___pad_4", edge_Y, edge, cp, cp, bc, kc, c, lh, fs);
    kb_pad_4.innerHTML = "4";

    var kb_pad_5 = this._setup_key(parent, "___pad_5", edge_Y, edge_1, cp, cp, bc, kc, c, lh, fs);
    kb_pad_5.innerHTML = "5";

    var kb_pad_6 = this._setup_key(parent, "___pad_6", edge_Y, edge_2, cp, cp, bc, kc, c, lh, fs);
    kb_pad_6.innerHTML = "6";

    edge_Y = (this._findY(kb_pad_4) + prevH + gap) + "px";

    var kb_pad_1 = this._setup_key(parent, "___pad_1", edge_Y, edge, cp, cp, bc, kc, c, lh, fs);
    kb_pad_1.innerHTML = "1";

    var kb_pad_2 = this._setup_key(parent, "___pad_2", edge_Y, edge_1, cp, cp, bc, kc, c, lh, fs);
    kb_pad_2.innerHTML = "2";

    var kb_pad_3 = this._setup_key(parent, "___pad_3", edge_Y, edge_2, cp, cp, bc, kc, c, lh, fs);
    kb_pad_3.innerHTML = "3";

    var kb_pad_enter = this._setup_key(parent, "___pad_enter", edge_Y, edge_3, cp, dp, bc, kc, c, dp2, parseFloat(fs) * 0.643, n);
    kb_pad_enter.innerHTML = "Enter";

    edge_Y = (this._findY(kb_pad_1) + prevH + gap) + "px";

    var kb_pad_0 = this._setup_key(parent, "___pad_0", edge_Y, edge, dp, cp, bc, kc, l, lh, fs, "", 7 * mag + "px");
    kb_pad_0.innerHTML = "0";

    var kb_pad_period = this._setup_key(parent, "___pad_period", edge_Y, edge_2, cp, cp, bc, kc, c, lh, fs);
    kb_pad_period.innerHTML = ".";

    this.LastKey = kb_pad_period;

    return String(this._findX(kb_pad_minus) + this._findW(kb_pad_minus) + gap) + "px";
  },

  _generic_callback_proc: function(event)
  {
    var e = event || window.event;
    var in_el = e.srcElement || e.target;
    var container_id = in_el.id.substring(0, in_el.id.indexOf("___"));

    var vpad = VNumpad.kbArray[container_id];

    if(vpad.sc) vpad._start_flash(in_el);

    if(vpad._Callback) vpad._Callback(in_el.innerHTML, vpad.Cntr.id);
  },

  SetParameters: function()
  {
    var l = arguments.length;
    if(!l || (l % 2 != 0)) return false;

    var p0, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10;

    while(--l > 0)
    {
      var value = arguments[l];

      switch(arguments[l - 1])
      {
        case "callback":
          p0 = ((typeof(value) == "function") && ((value.length == 1) || (value.length == 2))) ? value : this._Callback;
          break;

        case "font-name":  p1 = value; break;
        case "font-size":  p2 = value; break;
        case "font-color": p3 = value; break;
        case "base-color": p4 = value; break;
        case "key-color":  p5 = value; break;

        case "border-color": p6 = value; break;
        case "show-click":   p7 = value; break;

        case "click-font-color":   p8  = value; break;
        case "click-key-color":    p9 = value; break;
        case "click-border-color": p10 = value; break;

        default: break;
      }

      l -= 1;
    }

    this._construct(this.Cntr.id, p0, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10);

    return true;
  },

  Show: function(value)
  {
    var ct = this.Cntr.style;

    ct.display = ((value == undefined) || (value == true)) ? "block" : ((value == false) ? "none" : ct.display);
  }
};