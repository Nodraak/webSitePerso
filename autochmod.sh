# directories first
find * -type d | xargs chmod 755
# all files first
find * -type f | xargs chmod 644
# php files then
find * -type f | grep .php | xargs chmod 774
echo "autochmod : done changing permissions for folders below that one"
echo "autochmod : you now should have a working web page"
