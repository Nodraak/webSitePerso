# directories first
find * -type d | xargs chmod 771 # 755 ?
# all files first
find * -type f | xargs chmod 664
# php files then
find *.php* -type f | xargs chmod 770
echo "autochmod : done changing permissions for folders below that one"
echo "autochmod : you now should have a working web page"
