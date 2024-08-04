# Game Design Document

One document containing every detail about the game.

Start with a short description

Example contents:
  - Gameplay loop
  - Story
  - Style
  - Platform
  - Player Agency (how player will interact?)
  
Seperate Document for plot, short summary here

Platforms to release on
Player interaction, player limitations in detail
Dialog
Decisions
Player agency is important, player interaction needs to be damn near perfect to keep player engaged
Comparison of player interaction methods

Gameplay loop

How does the game start? Starting location, tutorial
Main gameplay loop? Combat, Stats, Items, Influence of Items of Combat, Item Progression (upgrades, crafting?), Armor Class, Hit Chance
Player Death

## Story and gameplay summary

The story is overall going to be grimdark, while not taking itself and the player serious.

You start as a newly-awaked skeleton in an unknown dungeon. You have no memories of who you were, you don't know why you're alive again, but you _do_ spawn with some items you are able to select via a starter class. Your first instinct is to get out of the dungeon you're in and find out who's responsible for you being a skeleton.

In-Game messages given to you by the narration are mostly meant to provide interesting flavour text and to give a very rough idea of your goals,
and you're unable to speak to anyone (you are a skeleton.). The lore and story of the game is conveyed mostly through in-game items and interactions between you, other npcs, items, and the environment.
The narration doesn't have any knowledge your character wouldn't be able to have.

The tutorial dungeon is heavily scripted and is meant to explain the basic gameplay loop while forcing you to interact with and learn the gameplay mechanics by using them. It also conveys some basic knowledge to your character, like the justification for your character existing in the world, what your overall goals are going to be, and how to achieve the next step (and only the next step) towards solving the current issues affecting your character. 

You're very likely (and supposed to) at least die once during the tutorial. This is meant to explain the death mechanic to the player in a controlled environment. The combat encounters and room layout is preset, as well as a boss area at the end. Every time you die, the actual rooms are randomized, but the overall layout of the tutorial dungeon stays the same.
You respawn at the start and loose any items, currency, and experience you acquire throughout the run. Long-term progression is primary handled through gaining knowledge about the game, helping you in new runs. The tutorial, once finished, doesn't need to be done again and the first dungeon is replaced by a normal randomized dungeon.

A key aspect of gameplay is resource managent. Health and Mana are limited and do not restore automatically. You have a limited amount of restoration available and restore them fully when resting. Resting is only possible at specific locations and only a limited amount of times per dungeon. 

Combat and interacting with the environment as well as movement, is turn-based and limited by a Stamina stat. During combat, a time limit is placed on turns. Stamina restores fully each turn.
The player, as well as the environment and combat encounters take alternating turns. Turn order is determined by an initiative stat.
Any action, damage, healing, or calculations are dice-roll based and influenced by character stats.
Body parts can be damaged and have a chance to detach when struck. Loosing a body part will limit the actions you can take, like only crawling when loosing a leg and dropping your weapon when loosing your sword arm. They can be picked up and reattached.

Dungeon rooms can contain enemies, containers, set dressing, objects, and environment puzzles. Combat encounters yield experience and possibly items and currency. Containers can contain items and currency.
Items can be used to interact with the environment, like opening containers and doors with keys, solving puzzles to unlock hidden rooms, ...
Some skills and spells can also interact with the environment in similar ways.

Finishing the tutorial dungeon lets you access the overworld. The overworld consists of adjacent map tiles. You enter at the tutorial dungeon exit and are free to chose where to go. The map tile your character is placed in is connected to other map tiles via paths. Choosing to follow a path moves your character to the next tile.
These map tiles can contain locations like other dungeon entrances, settlements, and similar places that have entrances. Entering moves you to an 'indoors' location (similar to skyrim). Further locations on the overworld map could be smaller huts, caves, but also encounters with enemies, merchants, and travellers that do not need you to enter a different map.

The first goal is to find a necromancer that can upgrade you from skeleton to undead. This will provide extra capabilities to the player, like decreased chance for limb damage, the ability to speak, and a fleshier overall appearance. The encounter is in a fixed location on the map, which is generated per player to avoid being able to share the location with other players. 
A big first piece of long term progression is finding the location.
