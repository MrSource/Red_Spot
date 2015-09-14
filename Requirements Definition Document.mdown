Requirements Definition Document
================================

### 1.	Introduction

*1.1	Purpose
The purpose of this document is to present and describe the requirements of the product to the developers.
*1.2	Scope
The name of the product is RedSpots, a social network that allows users to share, upload, rate and review recreational places like bars, clubs, beaches, etc. It is not intended to post personal statuses, show their relationship status or information about their work and education. The goal of the product is to create a social environment where users can share their experiences when visiting a social place, these experiences can motivate the user’s friends to visit the same places or draw them away.
*1.3	Acronyms
The product will replace the use of the terms friends/followers and location for spotters and spots, respectively, which are derived from the name of the social application.
*1.4	References
IEEE Standard 830: Software Requirements Specifications
http://www.csee.wvu.edu/~katerina/Teaching/CS-230-Spring-2006/CS-230-Sample-Formats.pdf
*1.5	Overview
The next part of the document contains detailed descriptions of the following:
*•	Product
*•	Features
*•	Implementation
*•	Users
*•	Constraints

--------------------------------------------------------------------------

### 2.	General Description

*2.1	Product perspective
RedSpots is an independent web application, linking to other social applications like Instagram and Facebook is not supported. 
*2.2	System Evolution
The life cycle used is the traditional Introduction-Growth-Maturity-Decline cycle. During the introduction, documentation and models will be presented. In the growth stage, the design and implementation of the features will be developed. During maturity, any other further implementation of the features is done as well as maintenance and bug fixes. Lastly, in the decline stage the maintenance will be less frequent.
*2.3	Product Functions
The essential functions of the product will be:
*•	User accounts to use the features of the social network.
*•	Relatives, friends and co-workers can be added as spotters.
*•	The app will display categories for different types of spots.
*•	Users can upload images, share, rate and review when visiting a spot.
*•	Locate the spot.
*•	Live feed where users can see the posts of their spotters.
*2.4	Users of the product
RedSpots is aimed to users that have the capabilities and opportunities to visit spots they are interested in. These users can be from young adults to elderly that have basic knowledge of the main components of social networks.
*2.5	General Constraints
Constraints for this product are mostly software wise. The main concern is that the application must access the device image gallery to upload pictures since RedSpots will not have authorization to access the camera of the device. Mobile devices must access the application from the browser of the device. 
*2.6	Assumptions and dependencies
Assuming that most or all of the essential features are developed in time, we can work on other desirables features, such as reporting misguided information on a post.
--------------------------------------------------------------------------
