Vagrant.configure("2") do |config|
	config.vm.box = 'kuikui/modern-lamp'
    config.vm.box_version = '>=2.3.0'
    config.vm.network :forwarded_port, guest: 8000, host: 1234

    config.vm.provider "virtualbox" do |v|
      v.memory = 1536
    end

    config.vm.provision "file", source: "~/.gitconfig", destination: "/vagrant/.gitconfig"
    config.vm.provision "file", source: "~/.gitignore_global", destination: "/vagrant/.gitignore_global"
    config.vm.provision "file", source: "~/.ssh/id_rsa", destination: "/vagrant/tmp/id_rsa"
    config.vm.provision "file", source: "~/.ssh/id_rsa.pub", destination: "/vagrant/tmp/id_rsa.pub"
    config.vm.provision "shell", path: "vagrant/provision.sh", keep_color: true, privileged: false
end