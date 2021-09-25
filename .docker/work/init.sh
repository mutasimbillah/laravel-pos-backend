echo "User $HOST_USER_ID"
id -u ubuntu > /dev/null 2>&1

if [ $? -ne 0 ]; then
	echo "Creating User ubuntu"
    adduser ubuntu --disabled-password --gecos '' --uid $HOST_USER_ID > /dev/null
    usermod ubuntu -a -G sudo  > /dev/null
    groupmod -g $HOST_GROUP_ID ubuntu  > /dev/null
    echo "ubuntu ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers
    chown -R ubuntu:ubuntu /home/ubuntu
fi

if [ ! -f ~/.local/share/mkcert/cert.pem ]; then
    DOMAIN=$(basename $APP_URL)
    chown -R $HOST_USER_ID:$HOST_GROUP_ID /home/ubuntu/.local
    runuser -l ubuntu -c "cd ~/.local/share/mkcert && mkcert $DOMAIN && mv $DOMAIN.pem cert.pem && mv $DOMAIN-key.pem key.pem"
fi
