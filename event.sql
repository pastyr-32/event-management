CREATE TABLE pentathanerd.team
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name text NOT NULL
);
CREATE UNIQUE INDEX team_id_uindex ON pentathanerd.team (id);

CREATE TABLE pentathanerd.team_roster
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    team_id int(11) NOT NULL,
    user_id int(11) NOT NULL
);
CREATE UNIQUE INDEX team_roster_id_uindex ON pentathanerd.team_roster (id);

CREATE TABLE pentathanerd.event
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name text NOT NULL
);
CREATE UNIQUE INDEX event_id_uindex ON pentathanerd.event (id);

CREATE TABLE pentathanerd.event_participant
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    event_id int(11) NOT NULL,
    team_id int(11) NOT NULL
);
CREATE UNIQUE INDEX event_participant_id_uindex ON pentathanerd.event_participant (id);

CREATE TABLE pentathanerd.participant_score
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    participant_id int(11) NOT NULL,
    score text NOT NULL
);
CREATE UNIQUE INDEX participant_score_id_uindex ON pentathanerd.participant_score (id);