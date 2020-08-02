<?php

namespace HyperEnte\JoinMessage;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;

class EventListener implements Listener{

	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$config = new Config(JoinMessage::getMain()->getDataFolder()."joinmessages.json", Config::JSON);
		$name = $player->getName();
		if($config->get($player->getName()) == false){
			$config->set($player->getName(), ["joinmessage" => "default"]);
			$config->save();
		}
		$info = $config->get("$name");
		if($info["joinmessage"] === "default"){
			$money = EconomyAPI::getInstance()->myMoney($player);
			date_default_timezone_set(JoinMessage::getMain()->getConfig()->get("timezone"));
			$time = date("H:i");
			$rank = JoinMessage::getMain()->getPlayerRank($player);
			$joinmsg = str_replace(
				array("[PLAYER]", "[MONEY]", "[TIME]", "[DARK_BLUE]", "[DARK_GREEN]", "[DARK_AQUA]", "[DARK_RED]", "[DARK_PURPLE]", "[GOLD]", "[GRAY]", "[DARK_GRAY]", "[BLUE]", "[BLACK]", "[GREEN]", "[AQUA]", "[RED]", "[LIGHT_PURPLE]", "[YELLOW]", "[WHITE]", "[RANK]"),
				array("$name", "$money", "[$time]", "§1", "§2", "§3", "§4", "§5", "§6", "§7", "§8", "§9", "§0", "§a", "§b", "§c", "§d", "§e", "§f", "$rank"),
				JoinMessage::getMain()->getConfig()->get("default")
			);
			$event->setJoinMessage($joinmsg);
		}
		if($info["joinmessage"] !== "default"){
			$money = EconomyAPI::getInstance()->myMoney($player);
			date_default_timezone_set(JoinMessage::getMain()->getConfig()->get("timezone"));
			$time = date("H:i");
			$rank = JoinMessage::getMain()->getPlayerRank($player);
			$joinmsg = str_replace(
				array("[PLAYER]", "[MONEY]", "[TIME]", "[DARK_BLUE]", "[DARK_GREEN]", "[DARK_AQUA]", "[DARK_RED]", "[DARK_PURPLE]", "[GOLD]", "[GRAY]", "[DARK_GRAY]", "[BLUE]", "[BLACK]", "[GREEN]", "[AQUA]", "[RED]", "[LIGHT_PURPLE]", "[YELLOW]", "[WHITE]", "[RANK]"),
				array("$name", "$money", "[$time]", "§1", "§2", "§3", "§4", "§5", "§6", "§7", "§8", "§9", "§0", "§a", "§b", "§c", "§d", "§e", "§f", "$rank"),
				$info["joinmessage"]
			);
			$event->setJoinMessage($joinmsg);
		}
	}
}