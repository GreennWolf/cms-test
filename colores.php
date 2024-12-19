


<table width="90%;height:90%;">
<script language="javascript">
var r = new Array("00","33","66","99","CC","FF");
var g = new Array("00","33","66","99","CC","FF");
var b = new Array("00","33","66","99","CC","FF");

for (i=0;i<r.length;i++){
    for (j=0;j<g.length;j++) {
        document.write("<tr>");
        for (k=0;k<b.length;k++) {
            var nuevoc = "#" + r[i] + g[j] + b[k];
            document.write("<td style=cursor:pointer;font-size:0.5em; onclick=\"window.opener.document.getElementById('<?php echo $_REQUEST['color']; ?>').value='"+nuevoc+"';window.close();\" bgcolor=\"" + nuevoc + "\" align=center>");
            document.write(nuevoc);
            document.write("</td>");
        }
        document.write("</tr>");
    }
}
</script>
</table>