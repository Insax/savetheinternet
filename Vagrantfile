Vagrant.configure("2") do |config|
    config.vm.box = "bento/ubuntu-16.04"

    config.vm.synced_folder "./", "/var/www/html",
        owner: "www-data", group: "www-data"

    config.vm.provision :shell, path: "./provision_vagrant.sh"

    config.vm.network :forwarded_port, guest: 80, host: 50080
end
