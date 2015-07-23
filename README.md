# oe1ToRss
Converts Entries of "7 Tage Ö1" http://oe1.orf.at/konsole?show=ondemand to an filtered RSS-Feed

#Usage
Deploy to server with PHP runtime, call `feed.php`.

The `title` parameter is interpreted as RegEx over the whole title entry and filters only elements that match.

##Examples
Only a fixed show
```
feed.php?title=Spielr%C3%A4ume
feed.php?title=Diagonal.*
```

Filters the longer journals everyday (ommits the sceond morning journal )S
```
feed.php?title=(Morgenjournal \(I\))|Mittagsjournal|Abendjournal
```

##Results
The resulting stream has as title the given RegEx (could be changed on request), and the entries, have a valid guid, their publishing timestamp, and the same short description as can be seen in the 7 Tage Ö1.



