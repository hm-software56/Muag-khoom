1. What is it?

   In this folder you can find the 24 additional layouts for the JavaScript
   Virtual Keyboard. Below is the list of these layouts, together with the
   web links to pages that served as sources to the appropriate layouts.

   European:

   - bulgarian:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD442.jsp

   - czech (alternative):

     http://www.bohemica.com/czechonline/czechkeyboard/index.htm

   - danish, 159:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD159.jsp

   - danish, 281:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD281.jsp

   - dutch:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD143.jsp

   - estonian:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD454.jsp

   - finnish:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD153.jsp

   - hungarian:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD208.jsp

   - icelandic:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD197.jsp

   - latvian:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD455.jsp

   - lithuanian:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD456.jsp

   - macedonian:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD449.jsp

   - norwegian, 155:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD155.jsp

   - norwegian, 281N:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD281N.jsp

   - polish, 214:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD214.jsp

   - polish, 457 (programmer's):

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD457.jsp

   - portugese:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD163.jsp

   - romanian:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD446.jsp

   - serbian (cyrillic script):

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD450.jsp

   - serbo-croatian (latin script):

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD234.jsp

   - slovak:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD245.jsp

   - swedish:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD285.jsp

   - ukrainian:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD465.jsp

   Asian:

   - arabic:

     http://www-306.ibm.com/software/globalization/topics/keyboards/KBD470.jsp

2. How to install (any of) these layouts?

   Do the following:

   1) find 'avail_langs' array definition in 'vkboard.js' (full variant)
      or 'vkboards.js' (slim variant) file;

   2) find the 'name.js' file in the directory with the desired layout;
      insert it's contents (as a new array member, separating with commas
      as necessary) to the 'avail_langs' array you've previously found;

   3) find the layout definition file in the directory with the desired layout;
      it is always the file which accompanies the 'name.js'. Append it's contents
      to the end of the 'vkboard.js' (or 'vkboardp.js') file, but before the closing
      '}' symbol.