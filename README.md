Web Application for Rett-Comm

<h3>Some notes:</h3>
<ol>
    <li>The voice is provided by Responsive Voice. When I first developed this application for my bachelor's thesis, I could download the Responsive Voice JS. However, apparently now I have to use the CDN with the key to use the library.</li>
    <li>The appliication was originally developed for a state hospital in Indonesia (Hasan Sadikin Hospital) to help the communication between the parents and the child (who is suffering from Rett Syndrome). Hence, the User Interface (UI) of the application is in Indonesian. However, I am planning to add English translation in the future, so other developers can use this application if needed.</li>
</ol>

<h3>How does this web application work?</h3>

This web application is meant to be run alongside either the gaze-tracking or head-pose app (both built using Python), which will move the mouse cursor using gaze-tracking or head-pose, respectively. The application will track how much time is spent for the cursor in the left or right area. Depending on the cursor movement, the application will automatically determine that the child chooses the activity on the left, activity on the right, or they still do not know what they want to do (because the cursor spends roughly equal amount of time in the left and right side of the screen, or there is barely any cursor movement). A dropdown is provided for the caregiver to change the activities shown on the screen. In addition, the caregiver can add activities and also add patients.