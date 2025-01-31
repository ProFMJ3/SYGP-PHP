
CREATE DATABASE sygp;
USE sygp;  

CREATE TABLE IF NOT EXISTS Users (  
    idUser INT PRIMARY KEY AUTO_INCREMENT,  
    username VARCHAR(100) UNIQUE,  
    email VARCHAR(100) UNIQUE,  
    passwords VARCHAR(100) 
);  

CREATE TABLE IF NOT EXISTS Projets (  
    idProjet INT PRIMARY KEY AUTO_INCREMENT,  
    nomProjet VARCHAR(100) UNIQUE,  
    descriptions TEXT,  
    duree VARCHAR(100),  
    dateDebut DATETIME DEFAULT CURRENT_TIMESTAMP,  
    dateFin DATE,  
    idUser INT,  
    FOREIGN KEY (idUser) REFERENCES Users(idUser) ON UPDATE CASCADE  
);  





CREATE TABLE IF NOT EXISTS Taches (  
    idTache INT PRIMARY KEY AUTO_INCREMENT,  
    nomTache VARCHAR(100),  
    descriptions TEXT, 
    dateDebut DATETIME DEFAULT CURRENT_TIMESTAMP, 
    dateEcheance DATE,  
    priorite VARCHAR(100),
    statut VARCHAR(100),
    progression INT DEFAULT 0,
    
    idProjet INT,  
    idUser INT,  
    FOREIGN KEY (idProjet) REFERENCES Projets(idProjet) ON DELETE CASCADE,  
    FOREIGN KEY (idUser) REFERENCES Users(idUser)  
);  

ALTER TABLE Taches MODIFY statut ENUM('En cours', 'Terminé') DEFAULT "A faire";
ALTER TABLE Taches MODIFY priorite  ENUM('Elevée', 'Moyenne', 'Faible') ;
ALTER TABLE Taches CHANGE dateDebut dateCreation  DATETIME DEFAULT NOW() ;
ALTER TABLE Taches ADD COLUMN fichier  VARCHAR(150)  AFTER progression;




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

ALTER TABLE Projets ADD COLUMN dateModification DATETIME NULL;
ALTER TABLE Projets ADD COLUMN etat ENUM('En cours', 'Terminé') DEFAULT 'En cours';
ALTER TABLE projets MODIFY dateCreation DATETIME DEFAULT NOW();
ALTER TABLE projets MODIFY nomProjet VARCHAR(100) UNIQUE;


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

ALTER TABLE Notifications
ADD COLUMN dateLecture DATETIME;


