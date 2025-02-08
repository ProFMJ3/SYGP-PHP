/*DROP DATABASE sygp;*/
CREATE DATABASE sygp;
USE sygp;  

CREATE TABLE IF NOT EXISTS Users (  
    idUser INT PRIMARY KEY AUTO_INCREMENT,  
    username VARCHAR(100) NOT NULL,  
    email VARCHAR(100) NOT NULL,  
    passwords VARCHAR(100),
    dateInscription DATETIME,
    dateModification DATETIME DEFAULT NULL
);  


CREATE TABLE IF NOT EXISTS Projets (  
    idProjet INT PRIMARY KEY AUTO_INCREMENT,  
    nomProjet VARCHAR(100) ,  
    descriptions TEXT,  
    etat ENUM('En cours', 'Terminé') DEFAULT 'En cours',
    dateCreation  DATETIME DEFAULT NOW() ,  
    dateFin DATE,  
    idUser INT,  
    FOREIGN KEY (idUser) REFERENCES Users(idUser) ON DELETE CASCADE,
    dateModification DATETIME DEFAULT NULL
);  


CREATE TABLE IF NOT EXISTS Taches(  
    idTache INT PRIMARY KEY AUTO_INCREMENT,  
    nomTache VARCHAR(100),  
    descriptions TEXT, 
    dateCreation DATETIME DEFAULT NOW(), 
    dateEcheance DATETIME,  
    statut ENUM('A faire','En cours', 'Terminé', 'Reporté') DEFAULT "A faire",
	priorite  ENUM('Elevée', 'Moyenne', 'Faible') ,
    progression INT DEFAULT 0,
    fichier VARCHAR(255) NULL ,
    fichierResultatFinal VARCHAR(255) DEFAULT NULL ,
    idProjet INT,  
    idUser INT,  
    FOREIGN KEY (idProjet) REFERENCES Projets(idProjet) ON DELETE CASCADE,  
    FOREIGN KEY (idUser) REFERENCES Users(idUser) ,
    dateModification DATETIME DEFAULT NULL
);  


CREATE TABLE Collaboration(
idCollaboration INT PRIMARY KEY AUTO_INCREMENT,
dateCollaboration DATETIME,
idProjet INT,
idUser INT, 
FOREIGN KEY (idProjet) REFERENCES Projets(idProjet) ON DELETE CASCADE,  
FOREIGN KEY (idUser) REFERENCES Users(idUser) ON DELETE CASCADE
);


CREATE TABLE Assignation(
idAssignation INT PRIMARY KEY AUTO_INCREMENT,
dateAssignation DATETIME,
idTache INT,
idUser INT, 
FOREIGN KEY (idTache) REFERENCES Taches(idProjet) ON DELETE CASCADE,  
FOREIGN KEY (idUser) REFERENCES Users(idUser) ON DELETE CASCADE
);



CREATE TABLE IF NOT EXISTS Notifications (  
    idNotif INT PRIMARY KEY AUTO_INCREMENT,  
    libelle TEXT,  
    idUser INT,  
    idTache INT,  
    idProjet INT,  
    etat ENUM('Non lue','Lue') DEFAULT 'Non lue',
    FOREIGN KEY (idUser) REFERENCES Users(idUser) ON DELETE CASCADE ,  
    FOREIGN KEY (idTache) REFERENCES Taches(idTache) On DELETE CASCADE,  
    FOREIGN KEY (idProjet) REFERENCES Projets(idProjet) ON DELETE CASCADE  
);



/*
ALTER TABLE Projets ADD COLUMN dateModification DATETIME DEFAULT NULL;
ALTER TABLE Projets ADD COLUMN etat ENUM('En cours', 'Terminé') DEFAULT 'En cours';
ALTER TABLE projets MODIFY dateCreation DATETIME DEFAULT NOW();
ALTER TABLE projets MODIFY nomProjet VARCHAR(100) UNIQUE;

ALTER TABLE Taches MODIFY statut ENUM('En cours', 'Terminé') DEFAULT "A faire";
ALTER TABLE Taches MODIFY priorite  ENUM('Elevée', 'Moyenne', 'Faible') ;
ALTER TABLE Taches CHANGE dateDebut dateCreation  DATETIME DEFAULT NOW() ;
ALTER TABLE Taches MODIFY dateEcheance DATETIME DEFAULT NOW() ;
ALTER TABLE Taches ADD COLUMN dateModification DATETIME NULL ;
ALTER TABLE Taches ADD COLUMN fichier  VARCHAR(150)  AFTER progression;
ALTER TABLE Notifications
ADD COLUMN dateLecture DATETIME;
/*

